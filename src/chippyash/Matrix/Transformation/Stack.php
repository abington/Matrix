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
use chippyash\Matrix\Matrix;
use chippyash\Matrix\Traits\AssertMatrixIsComplete;
use chippyash\Matrix\Traits\AssertParameterIsMatrix;
use chippyash\Matrix\Traits\AssertMatrixColumnsAreEqual;

/**
 * Stack two matrices
 *
 * [[a,b]   [[e,f]  [[a,b]
 *  [c,d]  C [g,h] = [c,d]
 *                   [e,f]
 *                   [g,h]]
 */
class Stack extends AbstractTransformation
{
    use AssertMatrixIsComplete;
    use AssertParameterIsMatrix;
    use AssertMatrixColumnsAreEqual;

    /**
     * Stack the $mA matrix on top of the $extra matrix
     *
     * @param Matrix $mA First matrix operand - required
     * @param Matrix $extra Second matrix operand - required
     *
     * @return Matrix
     *
     */
    public function transform(Matrix $mA, $extra = null)
    {
        $this->assertParameterIsMatrix($extra)
             ->assertMatrixColumnsAreEqual($mA, $extra)
             ->assertMatrixIsComplete($mA)
             ->assertMatrixIsComplete($extra);

        //previous checks have determined both matrices have same number of
        //columns - so we only need to check one for zero rows
        if ($mA->is('empty')) {
            return new Matrix(array());
        }

        $data = array_merge($mA->toArray(), $extra->toArray());

        return new Matrix($data);
    }

}
