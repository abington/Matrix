<?php
/*
 * Matrix library
 *
 * @author Ashley Kitson <akitson@zf4.biz>
 * @copyright Ashley Kitson, UK, 2014
 * @licence GPL V3 or later : http://www.gnu.org/licenses/gpl.html
 */

namespace Chippyash\Matrix\Transformation;

use Chippyash\Matrix\Matrix;
use Chippyash\Matrix\Traits\AssertMatrixIsComplete;
use Chippyash\Matrix\Exceptions\MatrixException;

/**
 * Reduce a matrix to its diagonal elements substituting non diagonal entries
 * with zero
 *
 */
class Diagonal extends AbstractTransformation
{
    use AssertMatrixIsComplete;

    /**
     * Reduce a matrix to its diagonal elements.
     * NB. This transformation does not necessarily mean the resultant *is* diagonal.
     * Use the IsDiagonal attribute test to ensure it is.
     *
     * @param Matrix $mA First matrix operand - required
     * @param void $extra ignored
     *
     * @return Matrix
     *
     * @throws MatrixException
     */
    protected function doTransform(Matrix $mA, $extra = null)
    {
        $this->assertMatrixIsComplete($mA);

        if ($mA->is('empty')) {
            return new Matrix(array());
        }
        $diagonal = array();
        $data = $mA->toArray();
        $size = $mA->rows();
        for ($row = 0; $row < $size; $row ++) {
            for ($col = 0; $col < $size; $col ++) {
                $diagonal[$row][$col] = ($row == $col ? $data[$row][$col] : 0);
            }
        }

        return new Matrix($diagonal);
    }
}
