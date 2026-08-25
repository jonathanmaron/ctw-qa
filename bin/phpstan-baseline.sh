#!/usr/bin/env bash

#
# PHPStan Baseline Generator
#
# Regenerates the PHPStan baseline file.

set -euo pipefail

#######################################
# Regenerates the PHPStan baseline.
# Notes:
#   --allow-empty-baseline keeps the command successful on a code base that
#   reports no errors. An empty baseline is the correct result there, not a
#   failure; without the option PHPStan exits non-zero and writes nothing.
# Exits:
#   The exit code of the PHPStan run, so that callers such as CI pipelines
#   see a genuine failure.
#######################################
main() {
  vendor/bin/phpstan analyse --generate-baseline --allow-empty-baseline
}

main "$@"
