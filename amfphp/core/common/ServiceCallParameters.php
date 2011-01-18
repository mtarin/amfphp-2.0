<?php
/**
 * an AMF request comes with a targetURI that must be parsed to a service name and a function name. This class parses the request targetURI, and holds the necessary
 * data for the service call
 *
 * @author Ariel Sommeria-klein
 */
class core_common_ServiceCallParameters {


    /**
     * the name of the service. parsed from targetURI
     * The service name can either be just the name of the class (MirrorService) or include a path(package/MirrorService)
     * separator for path can only be "/"
     *
     * @var <String>
     */
    public $serviceName;

    /**
     * the name of the method to execute on the service object
     * @var <String>
     */
    public $methodName;

    /**
     * the parameters to pass to the method being called on the service
     * @var <array>
     */
    public $methodParameters;

    /**
     * creates a ServiceCallParamaeters object from an core_amf_Message
     * supported separators in the targetURI are "/" and "."
     * @param core_amf_Message $amfMessage
     * @return core_common_ServiceCallParameters
     */
    public static function createFromAMFMessage(core_amf_Message $amfMessage){
        $targetURI = str_replace(".", "/", $amfMessage->targetURI);
        $split = explode("/", $targetURI);
        $ret = new core_common_ServiceCallParameters();
        $ret->methodName = array_pop($split);
        $ret->serviceName = join($split, "/");
        $ret->methodParameters = $amfMessage->data;
        return $ret;
    }
}
?>
