﻿import mx.transitions.Tween;import mx.transitions.easing.*;// ROLL OVER FUNCTIONS FOR STATE BUTTONSfunction stateRoll(stateclipr, curalphr, disptext, totshops) {   new Tween(stateclipr, "_alpha", none, curalphr, 100, 6, false);   textField_reg.text = disptext;   textField_sho.text = "UNIFIED SHOPS:"   textField_num.text = totshops;}function stateOut(stateclipo, curalpho) {	new Tween(stateclipo, "_alpha", none, curalpho, 40, 6, false);   textField_reg.text = "";   textField_sho.text = "";   textField_num.text = "";   }// ALBERTApbab.onRollOver = function() {	var nowalph:Number = pcab._alpha;	stateRoll(pcab, nowalph, "ALBERTA", 0);}pbab.onRollOut = function() {	var nowalph:Number = pcab._alpha;	stateOut(pcab, nowalph);}// CLICK FUNCTION DISABLED - NO SHOPSpbab.onRelease = function() {	_global.staPick = "AB";	_root.gotoAndPlay("can");} //// BRITISH COLUMBIApbbc.onRollOver = function() {	var nowalph:Number = pcbc._alpha;	stateRoll(pcbc, nowalph, "BRITISH COLUMBIA", 0);}pbbc.onRollOut = function() {	var nowalph:Number = pcbc._alpha;	stateOut(pcbc, nowalph);}/* CLICK FUNCTION DISABLED - NO SHOPSpbbc.onRelease = function() {	_global.staPick = "BC";	_root.gotoAndPlay("can");} */// MANITOBApbmb.onRollOver = function() {	var nowalph:Number = pcmb._alpha;	stateRoll(pcmb, nowalph, "MANITOBA", 0);}pbmb.onRollOut = function() {	var nowalph:Number = pcmb._alpha;	stateOut(pcmb, nowalph);}/* CLICK FUNCTION DISABLED - NO SHOPSpbmb.onRelease = function() {	_global.staPick = "MB";	_root.gotoAndPlay("can");} */// NEW BRUNSWICKpbnb.onRollOver = function() {	var nowalph:Number = pcnb._alpha;	stateRoll(pcnb, nowalph, "NEW BRUNSWICK", 0);}pbnb.onRollOut = function() {	var nowalph:Number = pcnb._alpha;	stateOut(pcnb, nowalph);}/* CLICK FUNCTION DISABLED - NO SHOPSpbnb.onRelease = function() {	_global.staPick = "NB";	_root.gotoAndPlay("can");} */// NEWFOUNDLAND & LABRADORpbnl.onRollOver = function() {	var nowalph:Number = pcnl._alpha;	stateRoll(pcnl, nowalph, "NEWFOUNDLAND & LABRADOR", 0);}pbnl.onRollOut = function() {	var nowalph:Number = pcnl._alpha;	stateOut(pcnl, nowalph);}/* CLICK FUNCTION DISABLED - NO SHOPSpbnl.onRelease = function() {	_global.staPick = "NL";	_root.gotoAndPlay("can");} */// NORTHWEST TERRITORIESpbnt.onRollOver = function() {	var nowalph:Number = pcnt._alpha;	stateRoll(pcnt, nowalph, "NORTHWEST TERRITORIES", 0);}pbnt.onRollOut = function() {	var nowalph:Number = pcnt._alpha;	stateOut(pcnt, nowalph);}/* CLICK FUNCTION DISABLED - NO SHOPSpbnt.onRelease = function() {	_global.staPick = "NT";	_root.gotoAndPlay("can");} */// NOVA SCOTIApbns.onRollOver = function() {	var nowalph:Number = pcns._alpha;	stateRoll(pcns, nowalph, "NOVA SCOTIA", 0);}pbns.onRollOut = function() {	var nowalph:Number = pcns._alpha;	stateOut(pcns, nowalph);}/* CLICK FUNCTION DISABLED - NO SHOPSpbns.onRelease = function() {	_global.staPick = "NS";	_root.gotoAndPlay("can");} */// NUNAVUTpbnu.onRollOver = function() {	var nowalph:Number = pcnu._alpha;	stateRoll(pcnu, nowalph, "NUNAVUT", 0);}pbnu.onRollOut = function() {	var nowalph:Number = pcnu._alpha;	stateOut(pcnu, nowalph);}/* CLICK FUNCTION DISABLED - NO SHOPSpbnu.onRelease = function() {	_global.staPick = "NU";	_root.gotoAndPlay("can");} */// ONTARIOpbon.onRollOver = function() {	var nowalph:Number = pcon._alpha;	stateRoll(pcon, nowalph, "ONTARIO", 0);}pbon.onRollOut = function() {	var nowalph:Number = pcon._alpha;	stateOut(pcon, nowalph);}/* CLICK FUNCTION DISABLED - NO SHOPSpbon.onRelease = function() {	_global.staPick = "ON";	_root.gotoAndPlay("can");} */// PRINCE EDWARD ISLANDpbpe.onRollOver = function() {	var nowalph:Number = pcpe._alpha;	stateRoll(pcpe, nowalph, "PRINCE EDWARD ISLAND", 0);}pbpe.onRollOut = function() {	var nowalph:Number = pcpe._alpha;	stateOut(pcpe, nowalph);}/* CLICK FUNCTION DISABLED - NO SHOPSpbpe.onRelease = function() {	_global.staPick = "PE";	_root.gotoAndPlay("can");} */// QUEBECpbqc.onRollOver = function() {	var nowalph:Number = pcqc._alpha;	stateRoll(pcqc, nowalph, "QUEBEC", 0);}pbqc.onRollOut = function() {	var nowalph:Number = pcqc._alpha;	stateOut(pcqc, nowalph);}/* CLICK FUNCTION DISABLED - NO SHOPSpbqc.onRelease = function() {	_global.staPick = "QC";	_root.gotoAndPlay("can");} */// SASKATCHEWANpbsk.onRollOver = function() {	var nowalph:Number = pcsk._alpha;	stateRoll(pcsk, nowalph, "SASKATCHEWAN", 0);}pbsk.onRollOut = function() {	var nowalph:Number = pcsk._alpha;	stateOut(pcsk, nowalph);}/* CLICK FUNCTION DISABLED - NO SHOPSpbsk.onRelease = function() {	_global.staPick = "SK";	_root.gotoAndPlay("can");} */// YUKON TERRITORYpbyt.onRollOver = function() {	var nowalph:Number = pcyt._alpha;	stateRoll(pcyt, nowalph, "YUKON TERRITORY", 0);}pbyt.onRollOut = function() {	var nowalph:Number = pcyt._alpha;	stateOut(pcyt, nowalph);}/* CLICK FUNCTION DISABLED - NO SHOPSpbyt.onRelease = function() {	_global.staPick = "YT";	_root.gotoAndPlay("can");} */