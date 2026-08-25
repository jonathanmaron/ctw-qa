#!/usr/bin/env bash

#
# PHPStan Grouped Results Generator
#
# Runs PHPStan analysis and generates sorted output files grouped by
# error identifier, along with a summary report.

set -euo pipefail

#######################################
# Constants
#######################################
readonly OUTPUT_DIR="build/phpstan"
readonly INPUT_FILE="${OUTPUT_DIR}/result.json"
readonly SUMMARY_FILE="${OUTPUT_DIR}/summary.txt"
readonly SEPARATOR_LONG="━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
readonly SEPARATOR_SHORT="━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
readonly LABEL_WIDTH=42

#######################################
# Globals
#######################################

# Exit code of the PHPStan run, set by run_phpstan() and propagated by main().
phpstan_exit_code=0

#######################################
# Prints an error message to stderr.
# Arguments:
#   Error message string
#######################################
err() {
  echo "[ERROR] $*" >&2
}

#######################################
# Runs PHPStan and generates JSON output.
# Globals:
#   INPUT_FILE
#   phpstan_exit_code
# Notes:
#   PHPStan returns a non-zero exit code when errors are found. The code is
#   recorded rather than discarded, so that the grouped report is still
#   generated and main() can propagate the failure to the caller.
#######################################
run_phpstan() {
  echo ""
  vendor/bin/phpstan --version
  echo ""
  vendor/bin/phpstan --error-format=json >"${INPUT_FILE}" \
    || phpstan_exit_code=$?
}

#######################################
# Pretty-formats the JSON result file in place.
# Globals:
#   INPUT_FILE
#   phpstan_exit_code
# Exits:
#   Non-zero if PHPStan did not produce parsable JSON.
#######################################
format_json() {
  local temp_file="${INPUT_FILE}.tmp"

  if ! jq . "${INPUT_FILE}" >"${temp_file}" 2>/dev/null; then
    rm -f "${temp_file}"
    err "PHPStan did not produce valid JSON output."
    cat "${INPUT_FILE}" >&2
    exit $((phpstan_exit_code > 0 ? phpstan_exit_code : 1))
  fi

  mv "${temp_file}" "${INPUT_FILE}"
}

#######################################
# Validates the PHPStan JSON output.
# Globals:
#   INPUT_FILE
# Returns:
#   0 if valid with issues, 1 otherwise
#######################################
validate_json() {
  if [[ ! -f "${INPUT_FILE}" ]]; then
    err "File ${INPUT_FILE} not found."
    exit 1
  fi

  if ! jq -e '.files != null and (.files | length > 0)' "${INPUT_FILE}" \
    >/dev/null; then
    echo "ℹ️ No issues found or invalid PHPStan JSON output."
    return 1
  fi

  return 0
}

#######################################
# Groups PHPStan errors by identifier and writes to separate files.
# Globals:
#   INPUT_FILE
#   OUTPUT_DIR
#   SEPARATOR_LONG
#######################################
group_errors_by_identifier() {
  local identifier file line message tip ignorable output_file

  jq -r '
    .files as $files |
    $files | to_entries[] |
    .key as $file |
    .value.messages[] |
    [
      .identifier,
      $file,
      (.line | tostring),
      .message,
      (if (.tip != null and (.tip | type) == "string") then .tip else "" end),
      (if (.ignorable == true) then "Yes" else "No" end)
    ] | @tsv
  ' "${INPUT_FILE}" \
    | while IFS=$'\t' read -r identifier file line message tip ignorable; do
      output_file="${OUTPUT_DIR}/${identifier}.txt"
      {
        echo "${SEPARATOR_LONG}"
        echo "🆔 Identifier : ${identifier}"
        echo "📂 File       : ${file}:${line}"
        echo "💬 Message    : ${message}"
        [[ -n "${tip}" ]] && echo "💡 Tip        : ${tip}"
        echo "✅ Ignorable  : ${ignorable}"
        echo "${SEPARATOR_LONG}"
        echo ""
      } >>"${output_file}"
    done
}

#######################################
# Generates a summary report of all identified issues.
# Globals:
#   OUTPUT_DIR
#   SUMMARY_FILE
#   SEPARATOR_SHORT
#   LABEL_WIDTH
#######################################
generate_summary() {
  local total_issues=0
  local total_identifiers=0
  local temp_summary_data
  local file identifier count

  temp_summary_data=$(mktemp)

  for file in "${OUTPUT_DIR}"/*.txt; do
    [[ "${file}" == "${SUMMARY_FILE}" ]] && continue

    identifier=$(basename "${file}" .txt)
    count=$(grep -c "📂 File" "${file}")

    printf -- "- %-${LABEL_WIDTH}s : %4d\n" "${identifier}" "${count}" \
      >>"${temp_summary_data}"
    total_issues=$((total_issues + count))
    total_identifiers=$((total_identifiers + 1))
  done

  {
    echo "${SEPARATOR_SHORT}"
    echo "🔎 PHPStan Scan Summary"
    echo "${SEPARATOR_SHORT}"
    printf -- "- %-${LABEL_WIDTH}s : %4d\n" "Unique Identifiers" \
      "${total_identifiers}"
    printf -- "- %-${LABEL_WIDTH}s : %4d\n" "Issues Found" "${total_issues}"
    echo "${SEPARATOR_SHORT}"
    echo ""
    echo "${SEPARATOR_SHORT}"
    echo "📋 Issues by Identifier:"
    echo "${SEPARATOR_SHORT}"
    sort "${temp_summary_data}"
    echo "${SEPARATOR_SHORT}"
  } >"${SUMMARY_FILE}"

  echo "📊 Summary written to ${SUMMARY_FILE}"
  rm -f "${temp_summary_data}"
}

#######################################
# Main entry point.
# Globals:
#   OUTPUT_DIR
#   SUMMARY_FILE
#   phpstan_exit_code
# Exits:
#   The exit code of the PHPStan run, so that callers such as CI pipelines
#   fail when errors were reported.
#######################################
main() {

  rm -rf "${OUTPUT_DIR}"
  mkdir -p "${OUTPUT_DIR}"

  run_phpstan
  format_json

  if ! validate_json; then
    exit "${phpstan_exit_code}"
  fi

  group_errors_by_identifier

  generate_summary

  echo ""
  cat "${SUMMARY_FILE}"

  exit "${phpstan_exit_code}"
}

main "$@"
