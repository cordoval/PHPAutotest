# features/ls.feature
Feature: minesweeper game
  In order to implement minesweeper game
  As a gamer programmer
  I need to be able to parse a grid

Background:
  Given I pass a grid:
   | * | . | . |
   | . | . | . |
   | . | . | * |
#   | 0 | 1 | 2 |
#   | * | . | . |
#   | . | . | . |
#   | . | . | * |
#   | 0 | 1 | 2 |
#   | * | 0 | 0 |
#   | 0 | 0 | 0 |
#   | 0 | 0 | * |
# RowsHash does not work reported to Behat @TODO
#   | 0 | * | . | . |
#   | 1 | . | . | . |
#   | 2 | . | . | * |

Scenario: Parse a grid 3 by 3
  When I run filter
  Then I should get:
   | * | 0 | 0 |
   | 0 | 0 | 0 |
   | 0 | 0 | * |

Scenario: Parse a grid 3 by 3 with neighbor awareness
  When I run filter with neighbor awareness
  Then I should get:
   | * | 1 | 0 |
   | 1 | 2 | 1 |
   | 0 | 1 | * |