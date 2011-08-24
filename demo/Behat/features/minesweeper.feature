# features/ls.feature
Feature: minesweeper game
  In order to implement minesweeper game
  As a gamer programmer
  I need to be able to parse a grid

Scenario: Parse a grid 3 by 3
  Given I pass a grid:
   | 0 | * | . | . |
   | 1 | . | . | . |
   | 2 | . | . | * |
  When I run filter
  Then I should get:
   | 0 | * | . | . |
   | 1 | . | . | . |
   | 2 | . | . | * |