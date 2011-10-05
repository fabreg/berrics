
$(document).ready(function() { 


	$("div[hash]").click(function() { 

		var id = $(this).attr("hash");
		
		document.location.href = '/canteen/cart/remove/'+id;
		
	});
	
	//the billing form
	$("#same-as-shipping-check").click(function() { 

		toggleBilling($("#same-as-shipping-check"));

	});
	toggleBilling($("#same-as-shipping-check"));
});

function toggleBilling(check) {


	if($(check).is(':checked')) {

		$("#billing-form").slideUp();
		
	} else {

		$("#billing-form").slideDown();

	}

	$('.form input[type=text],.form select').bind('blur keyup change',function() { 

		var id = $(this).attr("id");

		switch(id) {

			//void all optional fields
			case "CanteenOrderApt":
			break;
		
			case "CanteenOrderEmail":
				validateEmail(id);
			break;
			case "CardDataNumber":
				Mod10(id);
			break;
			case "CardDataExpMonth":
			case "CardDataExpYear":
				validateExp();
			break;
			default:
				validateTextField(id);
			break;
		
		}

		
	});

	
}

function validateTextField(id) {

	var ele = $("#"+id);
	var val = $(ele).val();
	var parent = $(ele).parent();
	if(val.length<2) {

		if(!$(parent).hasClass('bad')) {
			//$(parent).removeClass('good');
			$(parent).switchClass('good','bad','fast');
			

		}
		
	} else {

		if(!$(parent).hasClass('good')) {

		//	$(parent).removeClass('bad');
			$(parent).switchClass('bad','good','fast');
			
		}

	}
	
}

function validateSelect(id) {


	
}

function validateEmail(id) {

	 var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
	 var ele = $("#"+id);
		var val = $(ele).val();
		var parent = $(ele).parent();
	   if(reg.test(val) == false) {

		   if(!$(parent).hasClass('bad')) {

				$(parent).addClass('bad','fast');
				$(parent).removeClass('good');

			}
			 
	   } else {

		   if(!$(parent).hasClass('good')) {

				$(parent).addClass('good','fast');
				$(parent).removeClass('bad');
			}

	   }
	
}

function validateExp() {

	//var ele = $("#"+id);
	var pMonth = $("#CardDataExpMonth").parent();
	var pYear = $("#CardDataExpYear").parent();
	var month = $("#CardDataExpMonth").val();
	var year = "20"+$("#CardDataExpYear").val();

	var d = new Date();
	
	var t_month = d.getMonth();
	var t_year = d.getFullYear();

	var valid = false;
	if(((Number(year) == t_year) && (Number(month) >= (t_month+1))) || (Number(year)>t_year)) {

		valid = true;
		
	}

	if(!valid) {
		
		$(pMonth).switchClass('good','bad','fast');
		$(pYear).switchClass('good','bad','fast');
		
	} else {

		$(pMonth).switchClass('bad','good','fast');
		$(pYear).switchClass('bad','good','fast');

	}
	
	
}
function Mod10(id) {  

	var ele = $("#"+id);
	var val = $(ele).val();
	var ccNumb = val.replace(/\s+/g,'');
	var parent = $(ele).parent();

	var valid = "0123456789"  // Valid digits in a credit card number
	var len = ccNumb.length;  // The length of the submitted cc number
	var iCCN = parseInt(ccNumb);  // integer of ccNumb
	var sCCN = ccNumb.toString();  // string of ccNumb
	sCCN = sCCN.replace (/^s+|s+$/g,'');  // strip spaces
	var iTotal = 0;  // integer total set at zero
	var bNum = true;  // by default assume it is a number
	var bResult = false;  // by default assume it is NOT a valid cc
	var temp;  // temp variable for parsing string
	var calc;  // used for calculation of each digit

	// Determine if the ccNumb is in fact all numbers
	for (var j=0; j<len; j++) {
	  temp = "" + sCCN.substring(j, j+1);
	  if (valid.indexOf(temp) == "-1"){bNum = false;}
	}

	// if it is NOT a number, you can either alert to the fact, or just pass a failure
	if(!bNum){
	  /*alert("Not a Number");*/bResult = false;
	}

	// Determine if it is the proper length 
	if((len == 0)&&(bResult)){  // nothing, field is blank AND passed above # check
	  bResult = false;
	} else{  // ccNumb is a number and the proper length - let's see if it is a valid card number
	  if(len >= 15){  // 15 or 16 for Amex or V/MC
	    for(var i=len;i>0;i--){  // LOOP throught the digits of the card
	      calc = parseInt(iCCN) % 10;  // right most digit
	      calc = parseInt(calc);  // assure it is an integer
	      iTotal += calc;  // running total of the card number as we loop - Do Nothing to first digit
	      i--;  // decrement the count - move to the next digit in the card
	      iCCN = iCCN / 10;                               // subtracts right most digit from ccNumb
	      calc = parseInt(iCCN) % 10 ;    // NEXT right most digit
	      calc = calc *2;                                 // multiply the digit by two
	      // Instead of some screwy method of converting 16 to a string and then parsing 1 and 6 and then adding them to make 7,
	      // I use a simple switch statement to change the value of calc2 to 7 if 16 is the multiple.
	      switch(calc){
	        case 10: calc = 1; break;       //5*2=10 & 1+0 = 1
	        case 12: calc = 3; break;       //6*2=12 & 1+2 = 3
	        case 14: calc = 5; break;       //7*2=14 & 1+4 = 5
	        case 16: calc = 7; break;       //8*2=16 & 1+6 = 7
	        case 18: calc = 9; break;       //9*2=18 & 1+8 = 9
	        default: calc = calc;           //4*2= 8 &   8 = 8  -same for all lower numbers
	      }                                               
	    iCCN = iCCN / 10;  // subtracts right most digit from ccNum
	    iTotal += calc;  // running total of the card number as we loop
	  }  // END OF LOOP
	  if ((iTotal%10)==0){  // check to see if the sum Mod 10 is zero
	    bResult = true;  // This IS (or could be) a valid credit card number.
	  } else {
	    bResult = false;  // This could NOT be a valid credit card number
	    }
	  }
	}
	// change alert to on-page display or other indication as needed.
	
	if(!bResult) {
	
		   if(!$(parent).hasClass('bad')) {
	
				$(parent).addClass('bad');
				$(parent).removeClass('good');
	
			}
			 
	} else {
	
		   if(!$(parent).hasClass('good')) {
	
				$(parent).addClass('good');
				$(parent).removeClass('bad');
			}
	
	}
}