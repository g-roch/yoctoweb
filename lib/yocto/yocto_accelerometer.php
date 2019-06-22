<?php
/*********************************************************************
 *
 *  $Id: yocto_accelerometer.php 32907 2018-11-02 10:18:55Z seb $
 *
 *  Implements YAccelerometer, the high-level API for Accelerometer functions
 *
 *  - - - - - - - - - License information: - - - - - - - - -
 *
 *  Copyright (C) 2011 and beyond by Yoctopuce Sarl, Switzerland.
 *
 *  Yoctopuce Sarl (hereafter Licensor) grants to you a perpetual
 *  non-exclusive license to use, modify, copy and integrate this
 *  file into your software for the sole purpose of interfacing
 *  with Yoctopuce products.
 *
 *  You may reproduce and distribute copies of this file in
 *  source or object form, as long as the sole purpose of this
 *  code is to interface with Yoctopuce products. You must retain
 *  this notice in the distributed source file.
 *
 *  You should refer to Yoctopuce General Terms and Conditions
 *  for additional information regarding your rights and
 *  obligations.
 *
 *  THE SOFTWARE AND DOCUMENTATION ARE PROVIDED 'AS IS' WITHOUT
 *  WARRANTY OF ANY KIND, EITHER EXPRESS OR IMPLIED, INCLUDING
 *  WITHOUT LIMITATION, ANY WARRANTY OF MERCHANTABILITY, FITNESS
 *  FOR A PARTICULAR PURPOSE, TITLE AND NON-INFRINGEMENT. IN NO
 *  EVENT SHALL LICENSOR BE LIABLE FOR ANY INCIDENTAL, SPECIAL,
 *  INDIRECT OR CONSEQUENTIAL DAMAGES, LOST PROFITS OR LOST DATA,
 *  COST OF PROCUREMENT OF SUBSTITUTE GOODS, TECHNOLOGY OR
 *  SERVICES, ANY CLAIMS BY THIRD PARTIES (INCLUDING BUT NOT
 *  LIMITED TO ANY DEFENSE THEREOF), ANY CLAIMS FOR INDEMNITY OR
 *  CONTRIBUTION, OR OTHER SIMILAR COSTS, WHETHER ASSERTED ON THE
 *  BASIS OF CONTRACT, TORT (INCLUDING NEGLIGENCE), BREACH OF
 *  WARRANTY, OR OTHERWISE.
 *
 *********************************************************************/

//--- (YAccelerometer return codes)
//--- (end of YAccelerometer return codes)
//--- (YAccelerometer definitions)
if(!defined('Y_GRAVITYCANCELLATION_OFF'))    define('Y_GRAVITYCANCELLATION_OFF',   0);
if(!defined('Y_GRAVITYCANCELLATION_ON'))     define('Y_GRAVITYCANCELLATION_ON',    1);
if(!defined('Y_GRAVITYCANCELLATION_INVALID')) define('Y_GRAVITYCANCELLATION_INVALID', -1);
if(!defined('Y_BANDWIDTH_INVALID'))          define('Y_BANDWIDTH_INVALID',         YAPI_INVALID_INT);
if(!defined('Y_XVALUE_INVALID'))             define('Y_XVALUE_INVALID',            YAPI_INVALID_DOUBLE);
if(!defined('Y_YVALUE_INVALID'))             define('Y_YVALUE_INVALID',            YAPI_INVALID_DOUBLE);
if(!defined('Y_ZVALUE_INVALID'))             define('Y_ZVALUE_INVALID',            YAPI_INVALID_DOUBLE);
//--- (end of YAccelerometer definitions)
    #--- (YAccelerometer yapiwrapper)
   #--- (end of YAccelerometer yapiwrapper)

//--- (YAccelerometer declaration)
/**
 * YAccelerometer Class: Accelerometer function interface
 *
 * The YSensor class is the parent class for all Yoctopuce sensors. It can be
 * used to read the current value and unit of any sensor, read the min/max
 * value, configure autonomous recording frequency and access recorded data.
 * It also provide a function to register a callback invoked each time the
 * observed value changes, or at a predefined interval. Using this class rather
 * than a specific subclass makes it possible to create generic applications
 * that work with any Yoctopuce sensor, even those that do not yet exist.
 * Note: The YAnButton class is the only analog input which does not inherit
 * from YSensor.
 */
class YAccelerometer extends YSensor
{
    const BANDWIDTH_INVALID              = YAPI_INVALID_INT;
    const XVALUE_INVALID                 = YAPI_INVALID_DOUBLE;
    const YVALUE_INVALID                 = YAPI_INVALID_DOUBLE;
    const ZVALUE_INVALID                 = YAPI_INVALID_DOUBLE;
    const GRAVITYCANCELLATION_OFF        = 0;
    const GRAVITYCANCELLATION_ON         = 1;
    const GRAVITYCANCELLATION_INVALID    = -1;
    //--- (end of YAccelerometer declaration)

    //--- (YAccelerometer attributes)
    protected $_bandwidth                = Y_BANDWIDTH_INVALID;          // Int
    protected $_xValue                   = Y_XVALUE_INVALID;             // MeasureVal
    protected $_yValue                   = Y_YVALUE_INVALID;             // MeasureVal
    protected $_zValue                   = Y_ZVALUE_INVALID;             // MeasureVal
    protected $_gravityCancellation      = Y_GRAVITYCANCELLATION_INVALID; // OnOff
    //--- (end of YAccelerometer attributes)

    function __construct($str_func)
    {
        //--- (YAccelerometer constructor)
        parent::__construct($str_func);
        $this->_className = 'Accelerometer';

        //--- (end of YAccelerometer constructor)
    }

    //--- (YAccelerometer implementation)

    function _parseAttr($name, $val)
    {
        switch($name) {
        case 'bandwidth':
            $this->_bandwidth = intval($val);
            return 1;
        case 'xValue':
            $this->_xValue = round($val * 1000.0 / 65536.0) / 1000.0;
            return 1;
        case 'yValue':
            $this->_yValue = round($val * 1000.0 / 65536.0) / 1000.0;
            return 1;
        case 'zValue':
            $this->_zValue = round($val * 1000.0 / 65536.0) / 1000.0;
            return 1;
        case 'gravityCancellation':
            $this->_gravityCancellation = intval($val);
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns the measure update frequency, measured in Hz (Yocto-3D-V2 only).
     *
     * @return integer : an integer corresponding to the measure update frequency, measured in Hz (Yocto-3D-V2 only)
     *
     * On failure, throws an exception or returns Y_BANDWIDTH_INVALID.
     */
    public function get_bandwidth()
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_BANDWIDTH_INVALID;
            }
        }
        $res = $this->_bandwidth;
        return $res;
    }

    /**
     * Changes the measure update frequency, measured in Hz (Yocto-3D-V2 only). When the
     * frequency is lower, the device performs averaging.
     *
     * @param integer $newval : an integer corresponding to the measure update frequency, measured in Hz
     * (Yocto-3D-V2 only)
     *
     * @return integer : YAPI_SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_bandwidth($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("bandwidth",$rest_val);
    }

    /**
     * Returns the X component of the acceleration, as a floating point number.
     *
     * @return double : a floating point number corresponding to the X component of the acceleration, as a
     * floating point number
     *
     * On failure, throws an exception or returns Y_XVALUE_INVALID.
     */
    public function get_xValue()
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_XVALUE_INVALID;
            }
        }
        $res = $this->_xValue;
        return $res;
    }

    /**
     * Returns the Y component of the acceleration, as a floating point number.
     *
     * @return double : a floating point number corresponding to the Y component of the acceleration, as a
     * floating point number
     *
     * On failure, throws an exception or returns Y_YVALUE_INVALID.
     */
    public function get_yValue()
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_YVALUE_INVALID;
            }
        }
        $res = $this->_yValue;
        return $res;
    }

    /**
     * Returns the Z component of the acceleration, as a floating point number.
     *
     * @return double : a floating point number corresponding to the Z component of the acceleration, as a
     * floating point number
     *
     * On failure, throws an exception or returns Y_ZVALUE_INVALID.
     */
    public function get_zValue()
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_ZVALUE_INVALID;
            }
        }
        $res = $this->_zValue;
        return $res;
    }

    public function get_gravityCancellation()
    {
        // $res                    is a enumONOFF;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_GRAVITYCANCELLATION_INVALID;
            }
        }
        $res = $this->_gravityCancellation;
        return $res;
    }

    public function set_gravityCancellation($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("gravityCancellation",$rest_val);
    }

    /**
     * Retrieves an accelerometer for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     *
     * This function does not require that the accelerometer is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method YAccelerometer.isOnline() to test if the accelerometer is
     * indeed online at a given time. In case of ambiguity when looking for
     * an accelerometer by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the accelerometer
     *
     * @return YAccelerometer : a YAccelerometer object allowing you to drive the accelerometer.
     */
    public static function FindAccelerometer($func)
    {
        // $obj                    is a YAccelerometer;
        $obj = YFunction::_FindFromCache('Accelerometer', $func);
        if ($obj == null) {
            $obj = new YAccelerometer($func);
            YFunction::_AddToCache('Accelerometer', $func, $obj);
        }
        return $obj;
    }

    public function bandwidth()
    { return $this->get_bandwidth(); }

    public function setBandwidth($newval)
    { return $this->set_bandwidth($newval); }

    public function xValue()
    { return $this->get_xValue(); }

    public function yValue()
    { return $this->get_yValue(); }

    public function zValue()
    { return $this->get_zValue(); }

    public function gravityCancellation()
    { return $this->get_gravityCancellation(); }

    public function setGravityCancellation($newval)
    { return $this->set_gravityCancellation($newval); }

    /**
     * Continues the enumeration of accelerometers started using yFirstAccelerometer().
     * Caution: You can't make any assumption about the returned accelerometers order.
     * If you want to find a specific an accelerometer, use Accelerometer.findAccelerometer()
     * and a hardwareID or a logical name.
     *
     * @return YAccelerometer : a pointer to a YAccelerometer object, corresponding to
     *         an accelerometer currently online, or a null pointer
     *         if there are no more accelerometers to enumerate.
     */
    public function nextAccelerometer()
    {   $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if($resolve->errorType != YAPI_SUCCESS) return null;
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if($next_hwid == null) return null;
        return self::FindAccelerometer($next_hwid);
    }

    /**
     * Starts the enumeration of accelerometers currently accessible.
     * Use the method YAccelerometer.nextAccelerometer() to iterate on
     * next accelerometers.
     *
     * @return YAccelerometer : a pointer to a YAccelerometer object, corresponding to
     *         the first accelerometer currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstAccelerometer()
    {   $next_hwid = YAPI::getFirstHardwareId('Accelerometer');
        if($next_hwid == null) return null;
        return self::FindAccelerometer($next_hwid);
    }

    //--- (end of YAccelerometer implementation)

};

//--- (YAccelerometer functions)

/**
 * Retrieves an accelerometer for a given identifier.
 * The identifier can be specified using several formats:
 * <ul>
 * <li>FunctionLogicalName</li>
 * <li>ModuleSerialNumber.FunctionIdentifier</li>
 * <li>ModuleSerialNumber.FunctionLogicalName</li>
 * <li>ModuleLogicalName.FunctionIdentifier</li>
 * <li>ModuleLogicalName.FunctionLogicalName</li>
 * </ul>
 *
 * This function does not require that the accelerometer is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method YAccelerometer.isOnline() to test if the accelerometer is
 * indeed online at a given time. In case of ambiguity when looking for
 * an accelerometer by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 *
 * If a call to this object's is_online() method returns FALSE although
 * you are certain that the matching device is plugged, make sure that you did
 * call registerHub() at application initialization time.
 *
 * @param string $func : a string that uniquely characterizes the accelerometer
 *
 * @return YAccelerometer : a YAccelerometer object allowing you to drive the accelerometer.
 */
function yFindAccelerometer($func)
{
    return YAccelerometer::FindAccelerometer($func);
}

/**
 * Starts the enumeration of accelerometers currently accessible.
 * Use the method YAccelerometer.nextAccelerometer() to iterate on
 * next accelerometers.
 *
 * @return YAccelerometer : a pointer to a YAccelerometer object, corresponding to
 *         the first accelerometer currently online, or a null pointer
 *         if there are none.
 */
function yFirstAccelerometer()
{
    return YAccelerometer::FirstAccelerometer();
}

//--- (end of YAccelerometer functions)
?>