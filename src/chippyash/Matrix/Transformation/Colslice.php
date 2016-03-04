<?php
/*
 * Matrix library
 *
 * @author Ashley Kitson <akitson@zf4.biz>
 * @copyright Ashley Kitson, UK, 2014
 * @licence GPL V3 or later : http://www.gnu.org/licenses/gpl.html
 */

namespace chippyash\Matrix\Transformation;

use chippyash\Matrix\Transformation\AbstractTransformation;
use chippyash\Matrix\Transformation\Transpose;
use chippyash\Matrix\Transformation\Rowslice;
use chippyash\Matrix\Matrix;
use chippyash\Matrix\Exceptions\MatrixException;
use chippyash\Matrix\Traits\AssertParameterIsArray;

/**
 * Take a column slice of a Matrix
 */
class Colslice extends AbstractTransformation
{
    use AssertParameterIsArray;

    /**
     * Take a row slice from the matrix
     *
     * @param Matrix $mA First matrix operand - required
     * @param array $extra [int startCol, int numCols = 1]
     *
     * @return Matrix
     *
     * @throws chippyash/Matrix/Exceptions/MatrixException
     */
    protected function doTransform(Matrix $mA, $extra = null)
    {
        if ($mA->is('empty')) {
            return new Matrix(array());
        }

        $this->assertParameterIsArray($extra, 'Second operand is not an array');

        if (empty($extra)) {
            throw new MatrixException('Second operand does not contain col indicator');
        }
        $col = intval($extra[0]);
        $availableCols = $mA->columns();
        if ($col<1 || $col > $availableCols) {
            throw new MatrixException('Col indicator out of bounds');
        }

        $numCols = (isset($extra[1]) ? intval($extra[1]) : 1);
        if ($numCols < 1 || ($numCols+$col-1) > $availableCols) {
            throw new MatrixException('Numcols out of bounds');
        }

        $fT = new Transpose();
        $fR = new Rowslice();

        return $fT($fR($fT($mA), array($col, $numCols)));
    }

}