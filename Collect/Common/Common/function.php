<?php
function getPageNodeNotUseMethod() {
	$method = explode(",",C("PAGENODE_NOT_METHOD"));
	
	return $method;
}

function getFounder() {
	return explode(",", C("FOUNDER"));
}

function parseHost($host) {
	return "http://".$host;
}


function getParamUUid($host) {
	return md5($host);
}

function getUserId() {
	return session("userid");
}