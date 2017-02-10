<?php
/**
 * Simple excel writer class with no external dependencies, drop it in and have fun
 * @author Matt Nowack
 * @link https://gist.github.com/ihumanable/929039/edit
 * @license Unlicensed
 * @version 1.0
 */
class Excel {
  private $col;
  private $row;
  private $data;
  private $title;

  /**
   * Safely encode a string for use as a filename
   * @param string $title The title to use for the file
   * @return string The file safe title
   */
  static function filename($title) {
    $result = strtolower(trim($title));
    $result = str_replace("'", '', $result);
    $result = preg_replace('#[^a-z0-9_]+#', '-', $result);
    $result = preg_replace('#\-{2,}#', '-', $result);
    return preg_replace('#(^\-+|\-+$)#D', '', $result);
  }

  /**
   * Builds a new Excel Spreadsheet object
   * @return Excel The Spreadsheet
   */
  function __construct($title) {
    $this->title = $title;
    $this->col = 0;
    $this->row = 0;
    $this->data = '';
    $this->bofMarker();
  }

  /**
   * Transmits the proper headers to cause a download to occur and to identify the file properly
   * @return nothing
   */
  function headers() {
    header("Content-Type: application/force-download");
    header("Content-Type: application/octet-stream");
    header("Content-Type: application/download");
    header("Content-Disposition: attachment;filename=" . Excel::filename($this->title) . ".xls ");
    header("Content-Transfer-Encoding: binary ");
  }

  function send() {
    $this->eofMarker();
    $this->headers();
    echo $this->data;
  }

  /**
   * Writes the Excel Beginning of File marker
   * @see pack()
   * @return nothing
   */
  private function bofMarker() {
    $this->data .= pack("ssssss", 0x809, 0x8, 0x0, 0x10, 0x0, 0x0);
  }

  /**
   * Writes the Excel End of File marker
   * @see pack()
   * @return nothing
   */
  private function eofMarker() {
    $this->data .= pack("ss", 0x0A, 0x00);
  }

  /**
   * Moves internal cursor left by the amount specified
   * @param optional integer $amount The amount to move left by, defaults to 1
   * @return integer The current column after the move
   */
  function left($amount = 1) {
    $this->col -= $amount;
    if($this->col < 0) {
      $this->col = 0;
    }
    return $this->col;
  }

  /**
   * Moves internal cursor right by the amount specified
   * @param optional integer $amount The amount to move right by, defaults to 1
   * @return integer The current column after the move
   */
  function right($amount = 1) {
    $this->col += $amount;
    return $this->col;
  }

  /**
   * Moves internal cursor up by amount
   * @param optional integer $amount The amount to move up by, defaults to 1
   * @return integer The current row after the move
   */
  function up($amount = 1) {
    $this->row -= $amount;
    if($this->row < 0) {
      $this->row = 0;
    }
    return $this->row;
  }

  /**
   * Moves internal cursor down by amount
   * @param optional integer $amount The amount to move down by, defaults to 1
   * @return integer The current row after the move
   */
  function down($amount = 1) {
    $this->row += $amount;
    return $this->row;
  }

  /**
   * Moves internal cursor to the top of the page, row = 0
   * @return nothing
   */
  function top() {
    $this->row = 0;
  }

  /**
   * Moves internal cursor all the way left, col = 0
   * @return nothing
   */
  function home() {
    $this->col = 0;
  }

  /**
   * Writes a number to the Excel Spreadsheet
   * @see pack()
   * @param integer $value The value to write out
   * @return nothing
   */
  function number($value) {
    $this->data .= pack("sssss", 0x203, 14, $this->row, $this->col, 0x0);
    $this->data .= pack("d", $value);
  }

  /**
   * Writes a string (or label) to the Excel Spreadsheet
   * @see pack()
   * @param string $value The value to write out
   * @return nothing
   */
  function label($value) {
    $length = strlen($value);
    $this->data .= pack("ssssss", 0x204, 8 + $length, $this->row, $this->col, 0x0, $length);
    $this->data .= $value;
  }
}
