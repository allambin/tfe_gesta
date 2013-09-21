// eid-javascript-lib version 1.8

// Copyright (c) 2009-2011 Johan De Schutter (eidjavascriptlib AT gmail DOT com), http://code.google.com/p/eid-javascript-lib/

// Permission is hereby granted, free of charge, to any person obtaining a copy
// of this software and associated documentation files (the "Software"), to deal
// in the Software without restriction, including without limitation the rights
// to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
// copies of the Software, and to permit persons to whom the Software is
// furnished to do so, subject to the following conditions:

// The above copyright notice and this permission notice shall be included in
// all copies or substantial portions of the Software.

// THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
// IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
// FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
// AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
// LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
// OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
// THE SOFTWARE.

/*
	1.8 14/05/2011
	- Fix Firefox 4: method GetPicture of applet returns a value of type "function". The value is converted into an array.
	1.7 21/10/2010
	- Foreigner eID has a card number starting with B.
	- Kids-ID has a card number starting with 610.
	1.6 03/09/2010
	- Added reset method.
	1.5 14/11/2009
	- Added isCardPresent method.
	1.4 03/09/2009
	- Fix JRE 6 Update 15: check if applet is loaded as sub applet (using applet-launcher) or as main applet (using Next-Generation Java Plug-in).
	- Conversion of Java String objects returned by Java applets into Javascript Number objects fails in Safari.
	  Therefore Java String objects are first converted to Javascript String objects and then converted to Javascript Number objects.
	- DateFormatter is used to format dates in toString methods of Card-, EIDCard- or SISCard objects.
	1.3 16/08/2009
	- Added DateFormatter.
	- If the third first name is detected while parsing the first names, it is saved in the firstName3 property.
	- If someone has three firstnames and a first and second firstname that does not contain a space,
	  the first is saved in the firstName1 property and the second in firstName2 property.
	- Applet not found handler added.
	- Applet exception handler added.
	1.2 26/04/2009
	- Added Card object. This object is the base for EIDCard and SISCard.
	1.1 28/03/2009
	- Changed parsing of dates and social security number in SISCardBuilder35.
	- Getters of EIDCard and SISCard do not return Number- and Boolean objects anymore.
	  They will return primitive numbers and primitive booleans.
	1.0 24/03/2009
	- First release
*/

/*
 * Namespace be.belgium.eid
 */ 

/** 
 * @name be 
 * @namespace
 */
if (!window.be) window.be = new Object();
/** 
 * @name be.belgium
 * @namespace
 * @memberOf be
 */
if (!be.belgium) be.belgium = new Object();
/** 
 * @name be.belgium.eid 
 * @namespace
 * @memberOf be.belgium 
 */
 if (!be.belgium.eid) be.belgium.eid = new Object();
 
 /**
 * @fileOverview
 * Library of Javascript objects designed to retrieve data out of eID- and SIS cards using the applet from the eID middleware.
 *
 * The interface and implementation (identity data) of EIDCard and SISCard are designed to be eID middleware independent.
 * The interface and implementation of EIDCardBuilder35 and SISCardBuilder35 are designed for eID middleware 3.5. 
 * The interface of CardReader is designed to be middleware independent.
 * The implementation of CardReader uses EIDCardBuilder35- and SISCardBuilder35 objects and so it is designed for eID middleware 3.5.
 * 
 * If a new EID middleware is released, only new EIDCardBuilder- and SISCardBuilder objects should be created and 
 * only small changes will need to be applied to the implementation of the CardReader.
 * 
 * The interface of CardReader, EIDCard and SISCard will not change.
 * Therefore code that uses the CardReader-, EIDCard- and SISCard-objects will not have to be changed if a new eID middleware is released.
 * 
 * The library is supposed to work on Windows in Internet Explorer 5.5 and higher, in Mozilla Firefox 2 and higher, and in Opera 9 and higher.
 * Other browsers and other platforms were not tested.
 *
 * SIS cards can only be read when using a SIS card plugin. A SIS card plugin for the ACS ACR38U reader is available in the eID Quick Install.
 * More information about SIS card plugins in the eID V3 middleware can be found at: http://eid.belgium.be/nl/binaries/eid3_siscardplugins_tcm147-22479.pdf
 * 
 * @version 1.8 14/05/2011
 * @author Johan De Schutter (eidjavascriptlib AT gmail DOT com), http://code.google.com/p/eid-javascript-lib/
 */

/**
 * Enumeration of special status<br>
 * NO_STATUS : 0,<br>
 * WHITE_CANE : 1,<br>
 * EXTENDED_MINORITY : 2,<br>
 * WHITE_CANE_AND_EXTENDED_MINORITY : 3,<br>
 * YELLOW_CANE : 4,<br>
 * YELLOW_CANE_AND_EXTENDED_MINORITY : 5 
 * @memberOf be.belgium.eid
 */

be.belgium.eid.specialStatus = {
	NO_STATUS : 0,
	WHITE_CANE : 1,
	EXTENDED_MINORITY : 2,
	WHITE_CANE_AND_EXTENDED_MINORITY : 3,
	YELLOW_CANE : 4,
	YELLOW_CANE_AND_EXTENDED_MINORITY : 5
};

/**
 * Enumeration of document type<br>
 * UNDEFINED : 0,<br>
 * BELGIAN_CITIZEN : 1,<br>
 * EU_CITIZEN : 2,<br>
 * NON_EU_CITIZEN : 3,<br>
 * KIDS_EID : 6,<br>
 * BOOTSTRAP_CARD : 7,<br>
 * HABILITATION_CARD : 8,<br>
 * FOREIGNER_EID_A : 11,<br>
 * FOREIGNER_EID_B : 12,<br>
 * FOREIGNER_EID_C : 13,<br>
 * FOREIGNER_EID_D : 14,<br>
 * FOREIGNER_EID_E : 15,<br>
 * FOREIGNER_EID_E_PLUS : 16,<br>
 * FOREIGNER_EID_F : 17,<br>
 * FOREIGNER_EID_F_PLUS : 18 
 * @memberOf be.belgium.eid
 */

be.belgium.eid.documentType = {
	UNDEFINED : 0,
	BELGIAN_CITIZEN : 1,
	EU_CITIZEN : 2,
	NON_EU_CITIZEN : 3,
	KIDS_EID : 6,
	BOOTSTRAP_CARD : 7,
	HABILITATION_CARD : 8,
	FOREIGNER_EID_A : 11,
	FOREIGNER_EID_B : 12,
	FOREIGNER_EID_C : 13,
	FOREIGNER_EID_D : 14,
	FOREIGNER_EID_E : 15,
	FOREIGNER_EID_E_PLUS : 16,
	FOREIGNER_EID_F : 17,
	FOREIGNER_EID_F_PLUS : 18
};

/**
 * Enumeration of sex
 * FEMALE : 'F',<br>
 * MALE : 'M'
 * @memberOf be.belgium.eid
 */

be.belgium.eid.sex = { FEMALE : 'F', MALE : 'M' };

/**
 * Exception extends native javascript Error object.
 * Constructs a new exception with the specified detail message.
 * @description
 * @constructor
 * @param {primitive string|String} [s=""] detail message.
 */
be.belgium.eid.Exception = function(s) {
	if (s === null || typeof(s) == "undefined")
		this.message = "";
	else
		this.message = "" + s;
};
be.belgium.eid.Exception.prototype = new Error;
be.belgium.eid.Exception.prototype.name = "Exception";
/**
 * Return a short description (name and detail message) of this exception.
 * @public
 * @method toString
 * @return name and detail message.
 * @type primitive string
 */
be.belgium.eid.Exception.prototype.toString = function() {
	return this.name + ": " + this.message;
};

/**
 * IllegalArgumentException
 * @description
 * @constructor
 * @param {primitive string|String} [s=""] detail message.
 * @extends be.belgium.eid.Exception
 */
be.belgium.eid.IllegalArgumentException = function(s) {
	be.belgium.eid.Exception.call(this, s); // IE 5.5+
};
be.belgium.eid.IllegalArgumentException.prototype = new be.belgium.eid.Exception;
be.belgium.eid.IllegalArgumentException.prototype.name = "IllegalArgumentException";

/**
 * NullPointerException
 * @description
 * @constructor
 * @param {primitive string|String} [s=""] detail message.
 * @extends be.belgium.eid.Exception
 */
be.belgium.eid.NullPointerException = function(s) {
	be.belgium.eid.Exception.call(this, s); // IE 5.5+
};
be.belgium.eid.NullPointerException.prototype = new be.belgium.eid.Exception;
be.belgium.eid.NullPointerException.prototype.name = "NullPointerException";

/**
 * Enumeration of languages<br>
 * DUTCH : 0,<br>
 * FRENCH : 1,<br>
 * GERMAN : 2
 * @memberOf be.belgium.eid
 */
be.belgium.eid.language = {
	DUTCH : 0,
	FRENCH : 1,
	GERMAN : 2
};

/**
 * Enumeration of date formats<br>
 * DDMMYYYY : 0,<br>
 * MMDDYYYY : 1,<br>
 * YYYYMMDD : 2,<br>
 * DD_MM_YYYY : 3,<br>
 * MM_DD_YYYY : 4,<br>
 * YYYY_MM_DD : 5,<br>
 * EID_BIRTH_DATE : 6 
 * @memberOf be.belgium.eid
 */
be.belgium.eid.dateFormat = {
	DDMMYYYY : 0,
	MMDDYYYY : 1,
	YYYYMMDD : 2,
	DD_MM_YYYY : 3,
	MM_DD_YYYY : 4,
	YYYY_MM_DD : 5,
	EID_BIRTH_DATE : 6
};

/**
 * Object which formats and parses dates.
 * @description
 * @constructor
 * @param {be.belgium.eid.dateFormat} format the date format
 */
be.belgium.eid.DateFormatter = function(format) {
	this.dateFormat = format;
	if (format === be.belgium.eid.dateFormat.EID_BIRTH_DATE)
		this.dateSeparator = " ";
	else
		this.dateSeparator = "/";
	this.language = be.belgium.eid.language.DUTCH;

	//Array of birth date month abbreviations in Dutch, French and German
	this.eIDBirthDateAbbreviations = new Array(12);
	this.eIDBirthDateAbbreviations[0] = new Array("JAN");
	this.eIDBirthDateAbbreviations[1] = new Array("FEB", "FEV");
	this.eIDBirthDateAbbreviations[2] = new Array("MAAR", "MARS", "MÄR", "MAR");
	this.eIDBirthDateAbbreviations[3] = new Array("APR", "AVR");
	this.eIDBirthDateAbbreviations[4] = new Array("MEI", "MAI", "MAI");
	this.eIDBirthDateAbbreviations[5] = new Array("JUN", "JUIN");
	this.eIDBirthDateAbbreviations[6] = new Array("JUL", "JUIL");
	this.eIDBirthDateAbbreviations[7] = new Array("AUG", "AOUT");
	this.eIDBirthDateAbbreviations[8] = new Array("SEP", "SEPT");
	this.eIDBirthDateAbbreviations[9] = new Array("OKT", "OCT");
	this.eIDBirthDateAbbreviations[10] = new Array("NOV");
	this.eIDBirthDateAbbreviations[11] = new Array("DEC", "DEC", "DEZ");
};

/**
 * Set date separator. Only one character strings should be used.
 * @public
 * @method setDateSeparator
 * @param {primitive string|String} separator a date separator (one character).
 */
be.belgium.eid.DateFormatter.prototype.setDateSeparator = function(separator) {
	if (separator === null || typeof(separator) == "undefined")
		return;
	separator = new String(separator);
	if (separator.length == 0)
		return;
	this.dateSeparator = separator.substr(0,1);
};

/**
 * Return date separator.
 * @public
 * @method getDateSeparator
 * @return a date separator.
 * @type primitive string
 */
be.belgium.eid.DateFormatter.prototype.getDateSeparator = function() {
	return this.dateSeparator; 
};

/**
 * Set language used by EID_BIRTH_DATE date format.
 * @public
 * @method setLanguage
 * @param {be.belgium.eid.language} language a language (DUTCH, FRENCH, GERMAN).
 */
be.belgium.eid.DateFormatter.prototype.setLanguage = function(language) {
	switch (language) {
		case be.belgium.eid.language.DUTCH :
		case be.belgium.eid.language.FRENCH :
		case be.belgium.eid.language.GERMAN :
			this.language = language;
			break;
	}
};

/**
 * Return language.
 * @public
 * @method getLanguage
 * @return a language.
 * @type be.belgium.eid.language 
 */
be.belgium.eid.DateFormatter.prototype.getLanguage = function() {
	return this.language; 
};

/**
 * Parses text from the given string to produce a date.
 * @public
 * @method parse
 * @param dateString a string to be parsed.
 * @throws NullPointerException if dateString is null or undefined.
 * @throws IllegalArgumentException if dateString does not contain a valid date.
 * @return a Javascript Date object
 * @type Date
 */
be.belgium.eid.DateFormatter.prototype.parse = function(dateString) {
	if (dateString === null || typeof(dateString) == "undefined")
		throw new be.belgium.eid.NullPointerException();

	var day = 1;
	var month = 1;
	var year = 1970;

	if (this.dateFormat == be.belgium.eid.dateFormat.EID_BIRTH_DATE) {
		var length = dateString.length;
		var regExp;
		if (length < 11 || length > 12) // format DD mmmm YYYY (Dutch, French) or DD.MMM.YYYY (German)
			throw new be.belgium.eid.IllegalArgumentException();
		day = dateString.substr(0, 2);
		for (var i = 0; i < 12; i++) {
			regExp = new RegExp(this.eIDBirthDateAbbreviations[i].join("|"), "i");
			if (regExp.test(dateString)) {
				month = (i + 1);
				break;
			}
		}
		year = dateString.substr((length - 4), 4);
	} else {
		switch (this.dateFormat) {
			case be.belgium.eid.dateFormat.DDMMYYYY :
				if (dateString.length != 8)
					throw new be.belgium.eid.IllegalArgumentException();
				day = dateString.substr(0, 2);
				month = dateString.substr(2, 2);
				year = dateString.substr(4, 4);
				break;
			case be.belgium.eid.dateFormat.MMDDYYYY :
				if (dateString.length != 8)
					throw new be.belgium.eid.IllegalArgumentException();
				month = dateString.substr(0, 2);
				day = dateString.substr(2, 2);
				year = dateString.substr(4, 4);
				break;
			case be.belgium.eid.dateFormat.YYYYMMDD :
				if (dateString.length != 8)
					throw new be.belgium.eid.IllegalArgumentException();
				year = dateString.substr(0, 4);
				month = dateString.substr(4, 2);
				day = dateString.substr(6, 2);
				break;
			case be.belgium.eid.dateFormat.MM_DD_YYYY :
				if (dateString.length != 10)
					throw new be.belgium.eid.IllegalArgumentException();
				month = dateString.substr(0, 2);
				day = dateString.substr(3, 2);
				year = dateString.substr(6, 4);
				break;
			case be.belgium.eid.dateFormat.YYYY_MM_DD :
				if (dateString.length != 10)
					throw new be.belgium.eid.IllegalArgumentException();
				year = dateString.substr(0, 4);
				month = dateString.substr(5, 2);
				day = dateString.substr(8, 2);
				break;
			default: // be.belgium.eid.dateFormat.DD_MM_YYYY
				if (dateString.length != 10)
					throw new be.belgium.eid.IllegalArgumentException();
				day = dateString.substr(0, 2);
				month = dateString.substr(3, 2);
				year = dateString.substr(6, 4);
				break;
		}
	}

	if (day === "  ") day = 1;
	if (month === "  ") month = 1;

	return new Date(year, (month - 1), day, 0, 0, 0, 0);
};

/**
 * formats a given date into a date string.
 * @public
 * @method format
 * @param date a date to be formatted.
 * @throws NullPointerException if date is null or undefined.
 * @return a formatted date string
 * @type primitive string 
 */
be.belgium.eid.DateFormatter.prototype.format = function(date) {
	if (date === null || typeof(date) == "undefined")
		throw new be.belgium.eid.NullPointerException();

	var returnValue = "";

	var day = date.getDate();
	if (day < 10) day = "0" + day; // zero padding

	var month = date.getMonth();
	if (this.dateFormat == be.belgium.eid.dateFormat.EID_BIRTH_DATE) {
		var nbrAbbrev = this.eIDBirthDateAbbreviations[month].length;
		if (this.language < 0 || this.language >= nbrAbbrev) {
			month = this.eIDBirthDateAbbreviations[month][0];
		} else {
			month = this.eIDBirthDateAbbreviations[month][this.language];
		}
	} else {
		month = month + 1;
		if (month < 10) month = "0" + month; // zero padding
	}

	var year = date.getFullYear();

	switch (this.dateFormat) {
		case be.belgium.eid.dateFormat.DDMMYYYY :
			returnValue = "" + day + "" + month + "" + year;
			break;
		case be.belgium.eid.dateFormat.MMDDYYYY :
			returnValue = "" + month + "" + day + "" + year;
			break;
		case be.belgium.eid.dateFormat.YYYYMMDD :
			returnValue = "" + year + "" + month + "" + day;
			break;
		case be.belgium.eid.dateFormat.MM_DD_YYYY :
			returnValue = "" + month + this.dateSeparator + day + this.dateSeparator + year;
			break;
		case be.belgium.eid.dateFormat.YYYY_MM_DD :
			returnValue = "" + year + this.dateSeparator + month + this.dateSeparator + day;
			break;
		case be.belgium.eid.dateFormat.EID_BIRTH_DATE :
			returnValue = "" + day + this.dateSeparator + month + this.dateSeparator + year;
			break;
		default: // be.belgium.eid.dateFormat.DD_MM_YYYY
			returnValue = "" + day + this.dateSeparator + month + this.dateSeparator + year;
			break;
	}
	return returnValue;
};

/**
 * Convertor of JavaObject objects
 * @description
 * @constructor
 * @abstract 
 */
be.belgium.eid.JavaObjectConvertor = new Object();

/**
 * Java String objects returned by Java applets are converted into JavaObject objects.
 * This function converts these JavaObject objects into Javavascript String Objects.
 * @public
 * @static
 * @method toString
 * @parameter javaObject a JavaObject containing a string, returned by a Java applet
 * @throws NullPointerException if javaObject is null or undefined.
 * @return a Javascript String object
 * @type String
 */
be.belgium.eid.JavaObjectConvertor.toString = function(javaObject) {
	if (javaObject === null || typeof(javaObject) == "undefined")
		throw new be.belgium.eid.NullPointerException();
	return new String(javaObject);
};

/**
 * Java objects containing numbers returned by Java applets are converted into JavaObject objects.
 * This function converts these JavaObject objects into Javavascript Number Objects.
 * @public
 * @static
 * @method toNumber
 * @parameter javaObject a Javascript Object containing a number, returned by a Java applet
 * @throws NullPointerException if javaObject is null or undefined.
 * @throws IllegalArgumentException if javaObject does not contain a number.
 * @return a Javascript Number object
 * @type Number
 */
be.belgium.eid.JavaObjectConvertor.toNumber = function(javaObject) {
	if (javaObject === null || typeof(javaObject) == "undefined")
		throw new be.belgium.eid.NullPointerException();
	var num = new Number(javaObject);
	if (isNaN(num))
		throw new be.belgium.eid.IllegalArgumentException();
	else
		return num;
};

/**
 * Object which parses gender strings
 * @description
 * @constructor
 * @abstract 
 */
be.belgium.eid.GenderParser = new Object();
/**
 * @public
 * @static 
 * @method parse
 * @parameter str a string containing a gender
 * @throws NullPointerException if str is null or undefined.
 * @return value of type be.belgium.eid.sex
 * @type be.belgium.eid.sex
 */
be.belgium.eid.GenderParser.parse = function(str) {
	if (str === null || typeof(str) == "undefined")
		throw new be.belgium.eid.NullPointerException();
	var regExp = new RegExp("F|V|W", "i");
	if (regExp.test(str))
		return be.belgium.eid.sex.FEMALE;
	else
		return be.belgium.eid.sex.MALE;
};

/** 
 * Abstract object Card. No instance of this object should be created.
 * @description
 * @constructor
 * @abstract
 */ 
be.belgium.eid.Card = function() {
	this.cardNumber = new String("");
	this.validityBeginDate = new Date(0);
	this.validityEndDate = new Date(0);
};

/*
 * Setters and Getters
 */
 
be.belgium.eid.Card.prototype.setCardNumber = function(cardNumber) {
	if (cardNumber instanceof String)
		this.cardNumber = cardNumber;
	else
		this.cardNumber = new String(cardNumber);
};

/**
 * Return card number.
 * @public
 * @method getCardNumber
 * @return a String object containing card number.
 * @type String
 */
be.belgium.eid.Card.prototype.getCardNumber = function() {
	return this.cardNumber; 
};

be.belgium.eid.Card.prototype.setValidityBeginDate = function(beginDate) {
	this.validityBeginDate = beginDate;
};

/**
 * Return card validity begin date.
 * @public
 * @method getValidityBeginDate
 * @return a Date object containing card validity begin date.
 * @type Date
 */
be.belgium.eid.Card.prototype.getValidityBeginDate = function() {
	return this.validityBeginDate; 
};

be.belgium.eid.Card.prototype.setValidityEndDate = function(endDate) {
	this.validityEndDate = endDate;
};

/**
 * Return card validity end date.
 * @public
 * @method getValidityEndDate
 * @return a Date object containing card validity end date.
 * @type Date 
 */
be.belgium.eid.Card.prototype.getValidityEndDate = function() {
	return this.validityEndDate; 
};

/**
 * Returns a string representation of a card.
 * @public
 * @method toString
 * @return a string representation of a card.
 * @type primitive string
 */
be.belgium.eid.Card.prototype.toString = function() {
	var dateFormatter = new be.belgium.eid.DateFormatter(be.belgium.eid.dateFormat.DD_MM_YYYY);
	var newline = "\r\n";
	var str = "";
	str += "cardNumber: " + this.cardNumber + newline;
	str += "validityBeginDate: " + dateFormatter.format(this.validityBeginDate) + newline;
	str += "validityEndDate: " + dateFormatter.format(this.validityEndDate);
	return str;
};

/** 
 * EIDCard contains the public readable identity data of an eID card.
 * @description
 * Almost all the properties of this object are of type String, Number, Date or Boolean.
 * Some properties (sex, documentType, specialStatus) have types which are especially defined in this library.  
 * <p>
 * The applet from eID middleware 2.5.9 / 2.6 provided the methods getFirstName1, getFirstName2 and getFirstName3.
 * The applet from eID middleware 3.5 has only one method, getFirstName, which returns the first, second and third first names.
 * The third first name on the eID card is only the first letter of the third name.
 * Some people have a first name consisting of two words. For example Pieter Jan or Jean Marie.
 * So it is impossible to determine the second first name.
 * Still the EIDCard object has the firstName2 property in order to be backwards compatible
 * with the applet from eID middleware 2.5.9 / 2.6. But the firstName2 property is always an empty string.
 * Maybe in a future middleware, the applet will return the first names correctly.
 * <p>
 * Formats of identity data on an eID card are described in the following documents:
 * @see <a href="http://www.ibz.rrn.fgov.be/fileadmin/user_upload/CI/eID/5%20aspects%20techniques/nl/belgian_electronic_identity_card_content_v2.8.a.pdf">belgian_electronic_identity_card_content_v2.8.a.pdf</a><br>
 * @see <a href="http://www.ibz.rrn.fgov.be/fileadmin/user_upload/CI/eID/5%20aspects%20techniques/nl/format%20des%20dates/formaat_van_de_datums_04042006.pdf">formaat_van_de_datums_04042006.pdf</a>
 * @extends be.belgium.eid.Card
 * @constructor
 */
be.belgium.eid.EIDCard = function() {
	this.chipNumber = new String("");
	this.issuingMunicipality  = new String("");
	this.nationalNumber = new Number(0);
	this.surname = new String("");
	this.firstName1 = new String("");
	this.firstName2 = new String("");
	this.firstName3 = new String("");
	this.nationality = new String("");
	this.birthLocation = new String("");
	this.birthDate = new Date(0);
	this.sex = be.belgium.eid.sex.FEMALE;
	this.nobleCondition = new String("");
	this.documentType = be.belgium.eid.documentType.BELGIAN_CITIZEN;
	this.specialStatus = be.belgium.eid.specialStatus.NO_STATUS;
	this.whiteCane = new Boolean(false);
	this.yellowCane = new Boolean(false);
	this.extendedMinority = new Boolean(false);
	this.street = new String("");
	this.streetNumber = new String(""); // Usually digits, but street numbers like for example 32A do exist
	this.boxNumber = new String("");
	this.zipCode = new Number(0);
	this.municipality = new String("");
	this.country = new String("");
	this.picture = null; // byte array (type object, instanceof Array)
};
be.belgium.eid.EIDCard.prototype = new be.belgium.eid.Card; // extends Card

/**
 * Returns a string representation of public readable identity data of an eID card.
 * @public
 * @method toString
 * @return a string representation of public readable identity data of an eID card.
 * @type primitive string
 */
be.belgium.eid.EIDCard.prototype.toString = function() {
	var dateFormatter = new be.belgium.eid.DateFormatter(be.belgium.eid.dateFormat.DD_MM_YYYY);
	var newline = "\r\n";
	var str = "eID card" + newline;
	str += be.belgium.eid.Card.prototype.toString.call(this) + newline;
	str += "chipNumber: " + this.chipNumber + newline;
	str += "issuingMunicipality: " + this.issuingMunicipality + newline;
	str += "nationalNumber: " + this.nationalNumber.toString() + newline;
	str += "surname: " + this.surname + newline;
	str += "firstName1: " + this.firstName1 + newline;
	str += "firstName2: " + this.firstName2 + newline;
	str += "firstName3: " + this.firstName3 + newline;
	str += "nationality: " + this.nationality + newline;
	str += "birthLocation: " + this.birthLocation + newline;
	str += "birthDate: " + dateFormatter.format(this.birthDate) + newline;
	str += "sex: " + this.sex + newline;
	str += "nobleCondition: " + this.nobleCondition + newline;
	str += "documentType: " + this.documentType + newline;
	str += "specialStatus: " + this.specialStatus + newline;
	str += "whiteCane: " + this.whiteCane.toString() + newline;
	str += "yellowCane: " + this.yellowCane.toString() + newline;
	str += "extendedMinority: " + this.extendedMinority.toString() + newline;
	str += "street: " + this.street + newline;
	str += "streetNumber: " + this.streetNumber + newline;
	str += "boxNumber: " + this.boxNumber + newline;
	str += "zipCode: " + this.zipCode.toString() + newline;
	str += "municipality: " + this.municipality.toString() + newline;
	str += "country: " + this.country.toString() + newline;
	if (this.picture !== null) {
		str += "A picture is available.";
	} else {
		str += "No picture available.";
	}
	return str;
};

/*
 * Setters and Getters
 */

be.belgium.eid.EIDCard.prototype.setChipNumber = function(chipNumber) {
	if (chipNumber instanceof String)
		this.chipNumber = chipNumber;
	else
		this.chipNumber = new String(chipNumber);
};

/**
 * Return chip number.
 * @public
 * @method getChipNumber
 * @return a String object containing chip number.
 * @type String
 */
be.belgium.eid.EIDCard.prototype.getChipNumber = function() {
	return this.chipNumber; 
};

be.belgium.eid.EIDCard.prototype.setIssuingMunicipality = function(municipality) {
	if (municipality instanceof String)
		this.issuingMunicipality = municipality;
	else
		this.issuingMunicipality = new String(municipality);
};

/**
 * Return issuing municipality.
 * @public
 * @method getIssuingMunicipality
 * @return a String object containing issuing municipality.
 * @type String 
 */
be.belgium.eid.EIDCard.prototype.getIssuingMunicipality = function() {
	return this.issuingMunicipality; 
};

be.belgium.eid.EIDCard.prototype.setNationalNumber = function(nationalNumber) {
	if (nationalNumber instanceof Number)
		this.nationalNumber = nationalNumber;
	else
		this.nationalNumber = new Number(nationalNumber);
};

/**
 * Return national number.
 * @public
 * @method getNationalNumber
 * @return a primitive number containing national number.
 * @type primitive number 
 */
be.belgium.eid.EIDCard.prototype.getNationalNumber = function() {
	return this.nationalNumber.valueOf(); 
};

be.belgium.eid.EIDCard.prototype.setSurname = function(surname) {
	if (surname instanceof String)
		this.surname = surname;
	else
		this.surname = new String(surname);
};

/**
 * Return surname.
 * @public
 * @method getSurname
 * @return a String object containing surname.
 * @type String 
 */
be.belgium.eid.EIDCard.prototype.getSurname = function() {
	return this.surname; 
};

be.belgium.eid.EIDCard.prototype.setFirstName1 = function(firstName1) {
	if (firstName1 instanceof String)
		this.firstName1 = firstName1;
	else
		this.firstName1 = new String(firstName1);
};

/**
 * Return all first names.
 * @public
 * @method getFirstName1
 * @return a String object containing all first names.
 * @type String 
 */
be.belgium.eid.EIDCard.prototype.getFirstName1 = function() {
	return this.firstName1; 
};

be.belgium.eid.EIDCard.prototype.setFirstName2 = function(firstName2) {
	if (firstName2 instanceof String)
		this.firstName2 = firstName2;
	else
		this.firstName2 = new String(firstName2);
};

/**
 * Return first name part 2.
 * @public
 * @method getFirstName2
 * @return an empty String object.
 * @type String 
 */
be.belgium.eid.EIDCard.prototype.getFirstName2 = function() {
	return this.firstName2; 
};

be.belgium.eid.EIDCard.prototype.setFirstName3 = function(firstName3) {
	if (firstName3 instanceof String)
		this.firstName3 = firstName3;
	else
		this.firstName3 = new String(firstName3);
};

/**
 * Return first name part 3.
 * @public
 * @method getFirstName3
 * @return an empty String object.
 * @type String 
 */
be.belgium.eid.EIDCard.prototype.getFirstName3 = function() {
	return this.firstName3; 
};

be.belgium.eid.EIDCard.prototype.setNationality = function(nationality) {
	if (nationality instanceof String)
		this.nationality = nationality;
	else
		this.nationality = new String(nationality);
};

/**
 * Return nationality.
 * @public
 * @method getNationality
 * @return a String object containing nationality.
 * @type String 
 */
be.belgium.eid.EIDCard.prototype.getNationality = function() {
	return this.nationality; 
};

be.belgium.eid.EIDCard.prototype.setBirthLocation = function(birthLocation) {
	if (birthLocation instanceof String)
		this.birthLocation = birthLocation;
	else
		this.birthLocation = new String(birthLocation);
};

/**
 * Return birth location.
 * @public
 * @method getBirthLocation
 * @return a String object containing birth location.
 * @type String 
 */
be.belgium.eid.EIDCard.prototype.getBirthLocation = function() {
	return this.birthLocation; 
};

be.belgium.eid.EIDCard.prototype.setBirthDate = function(birthDate) {
	this.birthDate = birthDate;
};

/**
 * Return birth date.
 * @public
 * @method getBirthDate
 * @return a Date object containing birth date.
 * @type Date 
 */
be.belgium.eid.EIDCard.prototype.getBirthDate = function() {
	return this.birthDate; 
};

/*
 *  @param sex value of type be.belgium.eid.sex
 */
be.belgium.eid.EIDCard.prototype.setSex = function(sex) {
	this.sex = sex;
};

/**
 * Return sex.
 * @public
 * @method getSex
 * @return "F" for female, "M" for male
 * @type be.belgium.eid.sex
 */
be.belgium.eid.EIDCard.prototype.getSex = function() {
	return this.sex; 
};

/**
 * Return female sex status.
 * @public
 * @method getFemale
 * @return true if female, false if male.
 * @type primitive boolean 
 */
be.belgium.eid.EIDCard.prototype.getFemale = function() {
	return (this.sex === be.belgium.eid.sex.FEMALE); 
};

/**
 * Return male sex status.
 * @public
 * @method getMale
 * @return true if male, false if female.
 * @type primitive boolean 
 */
be.belgium.eid.EIDCard.prototype.getMale = function() {
	return (this.sex === be.belgium.eid.sex.MALE);
};

be.belgium.eid.EIDCard.prototype.setNobleCondition = function(nobleCondition) {
	if (nobleCondition instanceof String)
		this.nobleCondition = nobleCondition;
	else
		this.nobleCondition = new String(nobleCondition);
};

/**
 * Return noble condition.
 * @public
 * @method getNobleCondition
 * @return a String object containing noble condition.
 * @type String 
 */
be.belgium.eid.EIDCard.prototype.getNobleCondition = function() {
	return this.nobleCondition; 
};

/*
 *  @param documentType value of type be.belgium.eid.documentType
 */
be.belgium.eid.EIDCard.prototype.setDocumentType = function(documentType) {
	this.documentType = documentType;
};

/**
 * Return document type.
 * @public
 * @method getDocumentType
 * @return document type 
 * @type be.belgium.eid.documentType
 */
be.belgium.eid.EIDCard.prototype.getDocumentType = function() {
	return this.documentType; 
};

/*
 *  @param specialStatus value of type be.belgium.eid.specialStatus
 */
be.belgium.eid.EIDCard.prototype.setSpecialStatus = function(specialStatus) {
	this.specialStatus = specialStatus;
	
	// be.belgium.eid.specialStatus.NO_STATUS
	this.whiteCane = new Boolean(false);
	this.yellowCane = new Boolean(false);
	this.extendedMinority = new Boolean(false);	
	
	switch (this.specialStatus) {
		case be.belgium.eid.specialStatus.WHITE_CANE :
				this.whiteCane = new Boolean(true);
			break;
		case be.belgium.eid.specialStatus.EXTENDED_MINORITY :
				this.extendedMinority = new Boolean(true);
			break;
		case be.belgium.eid.specialStatus.WHITE_CANE_AND_EXTENDED_MINORITY :
				this.whiteCane = new Boolean(true);
				this.extendedMinority = new Boolean(true);
			break;
		case be.belgium.eid.specialStatus.YELLOW_CANE :
				this.yellowCane = new Boolean(true);
			break;
		case be.belgium.eid.specialStatus.YELLOW_CANE_AND_EXTENDED_MINORITY :
				this.yellowCane = new Boolean(true);
				this.extendedMinority = new Boolean(true);
			break;
	}
};

/**
 * Return special status.
 * @public
 * @method getSpecialStatus
 * @return special status
 * @type be.belgium.eid.specialStatus
 */
be.belgium.eid.EIDCard.prototype.getSpecialStatus = function() {
	return this.specialStatus; 
};

/**
 * Return white cane status (blind people).
 * @public
 * @method getWhiteCane
 * @return a primitive boolean containing white cane status.
 * @type primitive boolean 
 */
be.belgium.eid.EIDCard.prototype.getWhiteCane = function() {
	return this.whiteCane.valueOf();
};

/**
 * Return yellow cane status (partially sighted people).
 * @public
 * @method getYellowCane
 * @return a primitive boolean containing yellow cane status.
 * @type primitive boolean 
 */
be.belgium.eid.EIDCard.prototype.getYellowCane = function() {
	return this.yellowCane.valueOf();
};

/**
 * Return extended minority status.
 * @public
 * @method getExtendedMinority
 * @return a primitive boolean containing extended minority status.
 * @type primitive boolean 
 */
be.belgium.eid.EIDCard.prototype.getExtendedMinority = function() {
	return this.extendedMinority.valueOf();
};

be.belgium.eid.EIDCard.prototype.setStreet = function(street) {
	if (street instanceof String)
		this.street = street;
	else
		this.street = new String(street);
};

/**
 * Return street (including street number and box number on some cards).
 * @public
 * @method getStreet
 * @return a String object containing street.
 * @type String
 */
be.belgium.eid.EIDCard.prototype.getStreet = function() {
	return this.street; 
};

be.belgium.eid.EIDCard.prototype.setStreetNumber = function(streetNumber) {
	if (streetNumber instanceof String)
		this.streetNumber = streetNumber;
	else
		this.streetNumber = new String(streetNumber);
};

/**
 * Return street number. Street number can contain letters. For example 32A.
 * @public
 * @method getStreetNumber
 * @return a String object containing street number.
 * @type String 
 */
be.belgium.eid.EIDCard.prototype.getStreetNumber = function() {
	return this.streetNumber; 
};

be.belgium.eid.EIDCard.prototype.setBoxNumber = function(boxNumber) {
	if (boxNumber instanceof String)
		this.boxNumber = boxNumber;
	else
		this.boxNumber = new String(boxNumber);
};

/**
 * Return box number.
 * @public
 * @method getBoxNumber
 * @return a String object containing box number.
 * @type String 
 */
be.belgium.eid.EIDCard.prototype.getBoxNumber = function() {
	return this.boxNumber; 
};

be.belgium.eid.EIDCard.prototype.setZipCode = function(zipCode) {
	if (zipCode instanceof Number)
		this.zipCode = zipCode;
	else
		this.zipCode = new Number(zipCode);
};

/**
 * Return zip code.
 * @public
 * @method getZipCode
 * @return a primitive number containing zip code.
 * @type primitive number
 */
be.belgium.eid.EIDCard.prototype.getZipCode = function() {
	return this.zipCode.valueOf(); 
};

be.belgium.eid.EIDCard.prototype.setMunicipality = function(municipality) {
	if (municipality instanceof String)
		this.municipality = municipality;
	else
		this.municipality = new String(municipality);
};

/**
 * Return municipality.
 * @public
 * @method getMunicipality
 * @return a String object containing municipality.
 * @type String 
 */
be.belgium.eid.EIDCard.prototype.getMunicipality = function() {
	return this.municipality; 
};

be.belgium.eid.EIDCard.prototype.setCountry = function(country) {
	if (country instanceof String)
		this.country = country;
	else
		this.country = new String(country);
};

/**
 * Return country.
 * @public
 * @method getCountry
 * @return a String object containing country.
 * @type String
 */
be.belgium.eid.EIDCard.prototype.getCountry = function() {
	return this.country; 
};

be.belgium.eid.EIDCard.prototype.setPicture = function(pictureByteArray) {
	this.picture = pictureByteArray;
};

/**
 * Return picture.
 * @public
 * @method getPicture
 * @return a byte Array object containing picture.
 * @type byte Array
 */
be.belgium.eid.EIDCard.prototype.getPicture = function() {
	return this.picture;
};

/**
 * ForeignerEIDCard contains the public readable identity data of a foreigner eID card.
 * @description
 * A foreigner eID card contains the same data as an eID card for Belgian citizens.
 * @extends be.belgium.eid.EIDCard
 * @constructor
*/
be.belgium.eid.ForeignerEIDCard = function() {};
be.belgium.eid.ForeignerEIDCard.prototype = new be.belgium.eid.EIDCard; // extends EIDCard

/**
 * Returns a string representation of public readable identity data of a foreigner eID card.
 * @public
 * @method toString
 * @return a string representation of public readable identity data of a foreigner eID card.
 * @type primitive string
 */
be.belgium.eid.ForeignerEIDCard.prototype.toString = function() {
	var str = "foreigner " + be.belgium.eid.EIDCard.prototype.toString.call(this);
	return str;
};

/**
 * KidsEIDCard contains the public readable identity data of a kids eID card.
 * @description
 * A kids eID card contains the same data as an eID card for Belgian citizens.
 * @extends be.belgium.eid.EIDCard
 * @constructor
*/
be.belgium.eid.KidsEIDCard = function() {
	this.documentType = be.belgium.eid.documentType.KIDS_EID;
};
be.belgium.eid.KidsEIDCard.prototype = new be.belgium.eid.EIDCard; // extends EIDCard

/**
 * Returns a string representation of public readable identity data of a kids eID card.
 * @public
 * @method toString
 * @return a string representation of public readable identity data of a kids eID card.
 * @type primitive string
 */
be.belgium.eid.KidsEIDCard.prototype.toString = function() {
	var str = "kids " + be.belgium.eid.EIDCard.prototype.toString.call(this);
	return str;
};

/**
 * SISCard contains the public readable identity data of a SIS card.
 * @description
 * Almost all the properties of this object are of type String, Number, Date or Boolean.
 * Except property sex that has a type which is especially defined in this library. 
 * <p>
 * Formats of identity data on an SIS card are described in the following documents:   
 * @see <a href="http://www.ksz-bcss.fgov.be/nl/documentation/document_3.htm#document3_3">http://www.ksz-bcss.fgov.be/nl/documentation/document_3.htm#document3_3</a><br>
 * @see <a href="http://www.ksz-bcss.fgov.be/documentation/nl/documentation/appareils%20de%20lecture%20carte%20SIS/td-002bis-nl.pdf">http://www.ksz-bcss.fgov.be/documentation/nl/documentation/appareils%20de%20lecture%20carte%20SIS/td-002bis-nl.pdf</a>
 * @extends be.belgium.eid.Card
 * @constructor
 */
be.belgium.eid.SISCard = function() {
	this.socialSecurityNumber = new Number(0);
	this.surname = new String("");
	this.initials = new String("");
	this.name = new String("");
	this.sex = be.belgium.eid.sex.FEMALE;
	this.birthDate = new Date(0);
};
be.belgium.eid.SISCard.prototype = new be.belgium.eid.Card; // extends Card

/**
 * Returns a string representation of public readable identity data of a SIS card.
 * @public
 * @method toString
 * @return a string representation of public readable identity data of a SIS card.
 * @type primitive string
 */
be.belgium.eid.SISCard.prototype.toString = function() {
	var dateFormatter = new be.belgium.eid.DateFormatter(be.belgium.eid.dateFormat.DD_MM_YYYY);
	var newline = "\r\n";
	var str = "SIS card" + newline;
	str += be.belgium.eid.Card.prototype.toString.call(this) + newline;
	str += "socialSecurityNumber: " + this.socialSecurityNumber.toString() + newline;
	str += "surname: " + this.surname + newline;
	str += "initials: " + this.initials + newline;
	str += "name: " + this.name + newline;
	str += "sex: " + this.sex + newline;
	str += "birthDate: " + dateFormatter.format(this.birthDate);
	return str;
};

/*
 * Setters and Getters
 */

be.belgium.eid.SISCard.prototype.setSocialSecurityNumber = function(socialSecurityNumber) {	
	if (socialSecurityNumber instanceof Number)
		this.socialSecurityNumber = socialSecurityNumber;
	else
		this.socialSecurityNumber = new Number(socialSecurityNumber);
};

/**
 * Return social security number (= national number).
 * @public
 * @method getSocialSecurityNumber
 * @return a primitive number containing social security number.
 * @type primitive number 
 */
be.belgium.eid.SISCard.prototype.getSocialSecurityNumber = function() {
	return this.socialSecurityNumber.valueOf(); 
};

be.belgium.eid.SISCard.prototype.setSurname = function(surname) {
	if (surname instanceof String)
		this.surname = surname;
	else
		this.surname = new String(surname);
};

/**
 * Return surname.
 * @public
 * @method getSurname
 * @return a String object containing surname.
 * @type String 
 */
be.belgium.eid.SISCard.prototype.getSurname = function() {
	return this.surname; 
};

be.belgium.eid.SISCard.prototype.setInitials = function(initials) {
	if (initials instanceof String)
		this.initials = initials;
	else
		this.initials = new String(initials);
};

/**
 * Return initials.
 * @public
 * @method getInitials
 * @return a String object containing initials.
 * @type String 
 */
be.belgium.eid.SISCard.prototype.getInitials = function() {
	return this.initials; 
};

be.belgium.eid.SISCard.prototype.setName = function(name) {
	if (name instanceof String)
		this.name = name;
	else
		this.name = new String(name);
};

/**
 * Return first names.
 * @public
 * @method getName
 * @return a String object containing first names.
 * @type String 
 */
be.belgium.eid.SISCard.prototype.getName = function() {
	return this.name; 
};

/*
 *  @param sex value of type be.belgium.eid.sex
 */
be.belgium.eid.SISCard.prototype.setSex = function(sex) {
	this.sex = sex;
};

/**
 * Return sex.
 * @public
 * @method getSex
 * @return "F" for female, "M" for male
 * @type be.belgium.eid.sex
 */
be.belgium.eid.SISCard.prototype.getSex = function() {
	return this.sex; 
};

/**
 * Return female sex status.
 * @public
 * @method getFemale
 * @return true if female, false if male.
 * @type primitive boolean 
 */
be.belgium.eid.SISCard.prototype.getFemale = function() {
	return (this.sex === be.belgium.eid.sex.FEMALE); 
};

/**
 * Return male sex status.
 * @public
 * @method getMale
 * @return true if male, false if female.
 * @type primitive boolean 
 */
be.belgium.eid.SISCard.prototype.getMale = function() {
	return (this.sex === be.belgium.eid.sex.MALE);
};

be.belgium.eid.SISCard.prototype.setBirthDate = function(birthDate) {
	this.birthDate = birthDate;
};

/**
 * Return birth date.
 * @public
 * @method getBirthDate
 * @return a Date object containing birth date.
 * @type Date 
 */
be.belgium.eid.SISCard.prototype.getBirthDate = function() {
	return this.birthDate; 
};

/** 
 * Abstract object CardBuilder. No instance of this object should be created.
 * @description
 * @constructor
 * @abstract
 */ 
be.belgium.eid.CardBuilder = function() {
	this.card = null;
	this.birthDateFormatter = null;
	this.validityDateFormatter = null;
};

/**
 * Returns a card (eID card or SIS card) object. 
 * @public
 * @method getCard
 * @return an card object
 * @type EIDCard,SISCard
 */
be.belgium.eid.CardBuilder.prototype.getCard = function() {	
	return this.card;
};

be.belgium.eid.CardBuilder.prototype.setCardNumber = function(cardNumber) {
	try {
		if (this.card) {
			var cardNumberString = be.belgium.eid.JavaObjectConvertor.toString(cardNumber);
			this.card.setCardNumber(cardNumberString);
		}
	} catch (e){}
};

be.belgium.eid.CardBuilder.prototype.setValidityDateBegin = function(validityDateBegin) {
	try {
		if (this.card && this.validityDateFormatter)
			this.card.setValidityBeginDate(this.validityDateFormatter.parse(be.belgium.eid.JavaObjectConvertor.toString(validityDateBegin)));
	} catch (e){}
};

be.belgium.eid.CardBuilder.prototype.setValidityDateEnd = function(validityDateEnd) {
	try {
		if (this.card && this.validityDateFormatter)
			this.card.setValidityEndDate(this.validityDateFormatter.parse(be.belgium.eid.JavaObjectConvertor.toString(validityDateEnd)));
	} catch (e){}
};

be.belgium.eid.CardBuilder.prototype.setBirthDate = function(birthDate) {
	try {
		if (this.card && this.birthDateFormatter)
			this.card.setBirthDate(this.birthDateFormatter.parse(be.belgium.eid.JavaObjectConvertor.toString(birthDate)));
	} catch (e){}
};

/**
 * EIDCardBuilder35 extends CardBuilder.
 * EIDCardBuilder35, builds a EIDCard object step by step using data returned by the applet from eID middleware 3.5
 * <p>
 * Format of validity dates: DD.MM.YYYY (DD and MM can be empty strings, in this case DD = 01 and MM = 01 is presumed)<br>
 * Format of birth dates: DD MMMM YYYY (Dutch, French) or DD.MMM.YYYY (German) (DD and MMMM can be empty strings, in this case DD = 1 and MMMM = JAN is presumed)
 * <p>
 * Formats of identity data on an eID card are described in the following documents:
 * @see <a href="http://www.ibz.rrn.fgov.be/fileadmin/user_upload/CI/eID/5%20aspects%20techniques/nl/format%20des%20dates/formaat_van_de_datums_04042006.pdf">formaat_van_de_datums_04042006.pdf</a>
 * @see <a href="http://www.ibz.rrn.fgov.be/fileadmin/user_upload/CI/eID/5%20aspects%20techniques/nl/belgian_electronic_identity_card_content_v2.8.a.pdf">belgian_electronic_identity_card_content_v2.8.a.pdf</a>
 * @description
 * @constructor
 * @extends be.belgium.eid.CardBuilder
 */
be.belgium.eid.EIDCardBuilder35 = function(cardNumber) {
	var cardNumberString = new String("");
	try {
		cardNumberString = be.belgium.eid.JavaObjectConvertor.toString(cardNumber);
	} catch (e){}
	if (cardNumberString.indexOf("B") == 0) {
		this.card = new be.belgium.eid.ForeignerEIDCard();
	} else if (cardNumberString.indexOf("610") == 0) {
		this.card = new be.belgium.eid.KidsEIDCard();
	} else {
		this.card = new be.belgium.eid.EIDCard();
	}
	this.card.setCardNumber(cardNumberString);
	this.birthDateFormatter = new be.belgium.eid.DateFormatter(be.belgium.eid.dateFormat.EID_BIRTH_DATE);
	this.validityDateFormatter = new be.belgium.eid.DateFormatter(be.belgium.eid.dateFormat.DD_MM_YYYY);
};
be.belgium.eid.EIDCardBuilder35.prototype = new be.belgium.eid.CardBuilder; // extends CardBuilder

/*
 * Setters 
 * @public All these methods are public
 */

be.belgium.eid.EIDCardBuilder35.prototype.setChipNumber = function(chipNumber) {
	try {
		this.card.setChipNumber(be.belgium.eid.JavaObjectConvertor.toString(chipNumber));
	} catch (e){}
};

be.belgium.eid.EIDCardBuilder35.prototype.setIssMunicipality = function(issMunicipality) {
	try {
		this.card.setIssuingMunicipality(be.belgium.eid.JavaObjectConvertor.toString(issMunicipality));
	} catch (e){}
};

be.belgium.eid.EIDCardBuilder35.prototype.setNationalNumber = function(nationalNumber) {
	try {
		var nationalNumberString = be.belgium.eid.JavaObjectConvertor.toString(nationalNumber);
		this.card.setNationalNumber(be.belgium.eid.JavaObjectConvertor.toNumber(nationalNumberString.valueOf()));
	} catch (e){}
};

be.belgium.eid.EIDCardBuilder35.prototype.setSurname = function(surname) {
	try {
		this.card.setSurname(be.belgium.eid.JavaObjectConvertor.toString(surname));
	} catch (e){}
};

// Some people have a first name consisting of two words. For example Pieter Jan or Jean Marie
// So it is impossible to determine the second firstname.
be.belgium.eid.EIDCardBuilder35.prototype.setFirstName = function(firstName) {
	try {
		var firstnames = be.belgium.eid.JavaObjectConvertor.toString(firstName);
		var firstnamesArray = firstnames.split(" ");
		var length = firstnamesArray.length;
		if (length >= 3) {
			if (firstnamesArray[length - 1].length == 1) { // eID contains only first letter of 3rd name
				this.card.setFirstName3(firstnamesArray[length - 1]);
				firstnamesArray.pop(); // remove 3rd name
				if (firstnamesArray.length == 2) { // the first and second firstname does not contain a space
					this.card.setFirstName2(firstnamesArray[1]);
					firstnames = firstnamesArray[0];
				} else {
					firstnames = firstnamesArray.join(" "); // rejoin 1st and 2nd name
				}
			}
		}
		this.card.setFirstName1(firstnames);
	} catch (e){}
};

be.belgium.eid.EIDCardBuilder35.prototype.setNationality = function(nationality) {
	try {
		this.card.setNationality(be.belgium.eid.JavaObjectConvertor.toString(nationality));
	} catch (e){}
};

be.belgium.eid.EIDCardBuilder35.prototype.setBirthLocation = function(birthLocation) {
	try {
		this.card.setBirthLocation(be.belgium.eid.JavaObjectConvertor.toString(birthLocation));
	} catch (e){}
};

be.belgium.eid.EIDCardBuilder35.prototype.setSex = function(sex) {
	try {
		this.card.setSex(be.belgium.eid.GenderParser.parse(be.belgium.eid.JavaObjectConvertor.toString(sex)));
	} catch (e){}
};

be.belgium.eid.EIDCardBuilder35.prototype.setNobleCondition = function(nobleCondition) {
	try {
		this.card.setNobleCondition(be.belgium.eid.JavaObjectConvertor.toString(nobleCondition));
	} catch (e){}
};

be.belgium.eid.EIDCardBuilder35.prototype.setSpecialStatus = function(specialStatus) {
	try {
		var specialStatusString = be.belgium.eid.JavaObjectConvertor.toString(specialStatus);
		specialStatus = be.belgium.eid.JavaObjectConvertor.toNumber(specialStatusString.valueOf());
		this.card.setSpecialStatus(specialStatus.valueOf());
	} catch (e){}
};

be.belgium.eid.EIDCardBuilder35.prototype.setStreet = function(street) {
	try {
		this.card.setStreet(be.belgium.eid.JavaObjectConvertor.toString(street));
	} catch (e){}
};

be.belgium.eid.EIDCardBuilder35.prototype.setStreetNumber = function(streetNumber) {
	try {
		this.card.setStreetNumber(be.belgium.eid.JavaObjectConvertor.toString(streetNumber));
	} catch (e){}
};

be.belgium.eid.EIDCardBuilder35.prototype.setBoxNumber = function(boxNumber) {
	try {
		this.card.setBoxNumber(be.belgium.eid.JavaObjectConvertor.toString(boxNumber));
	} catch (e){}
};

be.belgium.eid.EIDCardBuilder35.prototype.setZip = function(zip) {
	try {
		var zipString = be.belgium.eid.JavaObjectConvertor.toString(zip);
		this.card.setZipCode(be.belgium.eid.JavaObjectConvertor.toNumber(zipString.valueOf()));
	} catch (e){}
};

be.belgium.eid.EIDCardBuilder35.prototype.setMunicipality = function(municipality) {
	try {
		this.card.setMunicipality(be.belgium.eid.JavaObjectConvertor.toString(municipality));
	} catch (e){}
};

be.belgium.eid.EIDCardBuilder35.prototype.setCountry = function(country) {
	try {
		this.card.setCountry(be.belgium.eid.JavaObjectConvertor.toString(country));
	} catch (e){}
};

be.belgium.eid.EIDCardBuilder35.prototype.setPicture = function(pictureByteArray) {
	try {
		this.card.setPicture(pictureByteArray);
	} catch (e){}
};

/**
 * SISCardBuilder35 extends CardBuilder.
 * SISCardBuilder35, builds a SISCard object step by step using data returned by the applet from eID middleware 3.5
 * <p>
 * Format of validity dates and birth dates: DD/MM/YYYY
 * <p>
 * Formats of identity data on a SIS card are described in the following documents:
 * @see <a href="http://www.ksz-bcss.fgov.be/nl/documentation/document_3.htm#document3_3">http://www.ksz-bcss.fgov.be/nl/documentation/document_3.htm#document3_3</a>
 * @see <a href="http://www.ksz-bcss.fgov.be/documentation/nl/documentation/appareils%20de%20lecture%20carte%20SIS/td-002bis-nl.pdf">http://www.ksz-bcss.fgov.be/documentation/nl/documentation/appareils%20de%20lecture%20carte%20SIS/td-002bis-nl.pdf</a>
 * @description
 * @constructor
 * @extends be.belgium.eid.CardBuilder
 */
be.belgium.eid.SISCardBuilder35 = function() {
	this.card = new be.belgium.eid.SISCard();
	this.birthDateFormatter = new be.belgium.eid.DateFormatter(be.belgium.eid.dateFormat.DD_MM_YYYY);
	this.validityDateFormatter = new be.belgium.eid.DateFormatter(be.belgium.eid.dateFormat.DD_MM_YYYY);
};
be.belgium.eid.SISCardBuilder35.prototype = new be.belgium.eid.CardBuilder; // extends CardBuilder

/**
 * Java String objects containing social security numbers returned by Java applets are converted into JavaObject objects.
 * This function converts these JavaObject objects into Javavascript Number Objects.
 * Format of social security number xxxxxx yyy zz
 * <p>
 * Format of social security number is described in the following documents:
 * @see <a href="http://www.ksz-bcss.fgov.be/Nl/faq/faq_5.htm">http://www.ksz-bcss.fgov.be/Nl/faq/faq_5.htm</a>
 * @see <a href="http://www.cla.be/Kort%20nieuws/2006/KN%20XIV-7-2.htm">http://www.cla.be/Kort%20nieuws/2006/KN%20XIV-7-2.htm</a>
 * @see <a href="http://www.cimire.fgov.be/siteindex.aspx?lng=nl&id=5">http://www.cimire.fgov.be/siteindex.aspx?lng=nl&id=5</a>
 * 
 * @private
 * @static
 * @method parseSocialSecurityNumber
 * @param appletNumberString a Javascript Object containing a social security number, returned by a Java applet
 * @throws NullPointerException if appletNumberString is null or undefined.
 * @throws IllegalArgumentException if appletNumberString does not contain a valid social security number.
 * @return a Javascript Number object
 * @type Number
 */
be.belgium.eid.SISCardBuilder35.parseSocialSecurityNumber = function(appletNumberString) {
	var str = be.belgium.eid.JavaObjectConvertor.toString(appletNumberString);
	if (str.length != 13)  // format xxxxxx yyy zz
		throw new be.belgium.eid.IllegalArgumentException();
	var numberStr = str.substr(0, 6) + str.substr(7, 3) + str.substr(11, 2);
	return be.belgium.eid.JavaObjectConvertor.toNumber(numberStr);
};

/*
 * Setters 
 * @public All these methods are public
 */

be.belgium.eid.SISCardBuilder35.prototype.setNationalNumber = function(nationalNumber) {
	try {
		this.card.setSocialSecurityNumber(be.belgium.eid.SISCardBuilder35.parseSocialSecurityNumber(nationalNumber));
	} catch (e){}
};

be.belgium.eid.SISCardBuilder35.prototype.setSurname = function(surname) {
	try {
		this.card.setSurname(be.belgium.eid.JavaObjectConvertor.toString(surname));
	} catch (e){}
};

be.belgium.eid.SISCardBuilder35.prototype.setFirstName = function(firstName) {
	try {
		this.card.setName(be.belgium.eid.JavaObjectConvertor.toString(firstName));
	} catch (e){}
};

be.belgium.eid.SISCardBuilder35.prototype.setInitials = function(initials) {
	try {
		this.card.setInitials(be.belgium.eid.JavaObjectConvertor.toString(initials));
	} catch (e){}
};

be.belgium.eid.SISCardBuilder35.prototype.setSex = function(sex) {
	try {
		this.card.setSex(be.belgium.eid.GenderParser.parse(be.belgium.eid.JavaObjectConvertor.toString(sex)));
	} catch (e){}
};

/**
 * CardReader, object that uses the applet from eID middleware 3.5 to read eID- or SIS cards.
 * @description
 * @constructor
 * @param {primitive string|String} [readerName=""] Name of reader which is used to read eID- or SIS-cards (optional). 
 */
be.belgium.eid.CardReader = function(readerName) {
	this.readerName = "";
	this.setReaderName(readerName);
	this.appletLauncherId = "BEIDAppletLauncher";
	this.noCardPresentHandler = null;
	this.noReaderDetectedHandler = null;
	this.appletNotFoundHandler = null;
	this.appletExceptionHandler = null;
	this.BEIDApplet = null;
};

/**
 * Return BEID applet (which is the applet downloaded by the applet launcher).
 * @public
 * @method getBEIDApplet
 * @throws NullPointerException if no BEID applet is found.
 * @return BEID applet.
 * @type Object
 */
be.belgium.eid.CardReader.prototype.getBEIDApplet = function() {
	if (!this.BEIDApplet) {
		if (document.getElementById(this.appletLauncherId)) {
			// check if applet is loaded as sub applet (using applet-launcher) or as main applet (using Next-Generation Java Plug-in).
			if (document.getElementById(this.appletLauncherId).getSubApplet) {
				this.BEIDApplet = document.getElementById(this.appletLauncherId).getSubApplet();
			} else {
				this.BEIDApplet = document.getElementById(this.appletLauncherId);
			}
		}
		if (!this.BEIDApplet)
			throw new be.belgium.eid.NullPointerException();
	}
	return this.BEIDApplet;
};

/**
 * Set name of reader which is used to read eID- or SIS-cards.
 * @public
 * @method setReaderName
 * @param {primitive string|String} readerName
 */
be.belgium.eid.CardReader.prototype.setReaderName = function(readerName) {
	if (readerName === null || typeof(readerName) == "undefined")
		this.readerName = "";
	else if (readerName instanceof String)
		this.readerName = readerName.valueOf();
	else
		this.readerName = readerName;
};

/**
 * Return name of reader which is used to read eID- or SIS-cards.
 * @public
 * @method getReaderName
 * @return reader name
 * @type primitive string
 */
be.belgium.eid.CardReader.prototype.getReaderName = function() {
	return this.readerName;
};

/**
 * Set id of the applet launcher APPLET-TAG.
 * @public
 * @method setAppletLauncherId
 * @param {primitive string} appletLauncherId
 */
be.belgium.eid.CardReader.prototype.setAppletLauncherId = function(appletLauncherId) {
	this.appletLauncherId = appletLauncherId;
	this.BEIDApplet = null;
};

/**
 * Return id of the applet launcher APPLET-TAG.
 * @public
 * @method getAppletLauncherId 
 * @return id of the applet launcher
 * @type primitive string
 */
be.belgium.eid.CardReader.prototype.getAppletLauncherId = function() {
	return this.appletLauncherId;
};

/**
 * Set handler function that is called when no card is present.
 * @public
 * @method setNoCardPresentHandler 
 * @param {function|Function Object} handler reference to a function or a Function object.
 */
be.belgium.eid.CardReader.prototype.setNoCardPresentHandler = function(handler) {
	if (handler !== null && typeof(handler) != "undefined" && (typeof(handler) == "function" || handler instanceof Function))
		this.noCardPresentHandler = handler;
	else
		this.noCardPresentHandler = null;
};

/**
 * Set handler function that is called when no reader is detected.
 * @public
 * @method setNoReaderDetectedHandler
 * @param {function|Function Object} handler reference to a function or a Function object.
 */
be.belgium.eid.CardReader.prototype.setNoReaderDetectedHandler = function(handler) {
	if (handler !== null && typeof(handler) != "undefined" && (typeof(handler) == "function" || handler instanceof Function))
		this.noReaderDetectedHandler = handler;
	else
		this.noReaderDetectedHandler = null;
};

/**
 * Set handler function that is called when BEID applet is not found.
 * @public
 * @method setAppletNotFoundHandler
 * @param {function|Function Object} handler reference to a function or a Function object.
 */
be.belgium.eid.CardReader.prototype.setAppletNotFoundHandler = function(handler) {
	if (handler !== null && typeof(handler) != "undefined" && (typeof(handler) == "function" || handler instanceof Function))
		this.appletNotFoundHandler = handler;
	else
		this.appletNotFoundHandler = null;
};

/**
 * Set handler function that is called when the BEID applet throws an exception.
 * @public
 * @method setAppletExceptionHandler
 * @param {function|Function Object} handler reference to a function or a Function object.
 */
be.belgium.eid.CardReader.prototype.setAppletExceptionHandler = function(handler) {
	if (handler !== null && typeof(handler) != "undefined" && (typeof(handler) == "function" || handler instanceof Function))
		this.appletExceptionHandler = handler;
	else
		this.appletExceptionHandler = null;
};

/**
 * Return a array of reader names.
 * @public
 * @method getReaderNames
 * @return an array of reader names, an zero length array is returned if no readers are detected.
 * @type Array of primitive strings
 */
be.belgium.eid.CardReader.prototype.getReaderNames = function() {
	var readerNames = new Array(0);
	try {
		this.getBEIDApplet().InitLib(null);
		var nbrReaders = this.BEIDApplet.readerCount();
		readerNames = new Array(nbrReaders);
		for (var i = 0; i < nbrReaders; i++) {
			readerNames[i] = "" + this.BEIDApplet.getReaderByNum(i);
		}
	} catch (e){} // catch Javascript and Java exceptions

	try {
		this.getBEIDApplet().exitLib();
	} catch (e){} // catch Javascript and Java exceptions

	return readerNames;
};

/**
 * Return default reader name (= first reader name in list of reader names)
 * @public
 * @method getDefaultReaderName
 * @return the default reader name or an empty string if no reader is detected.
 * @type primitive string
 */
be.belgium.eid.CardReader.prototype.getDefaultReaderName = function() {
	var defaultReaderName = "";
	try {
		this.getBEIDApplet().InitLib(null);
		defaultReaderName = "" + this.BEIDApplet.getReaderByNum(0);
	} catch (e){} // catch Javascript and Java exceptions

	try {
		this.getBEIDApplet().exitLib();
	} catch (e){} // catch Javascript and Java exceptions

	return defaultReaderName;
};

/**
 * determine reader name (default reader name or reader name defined as applet parameter)
 * @private
 * @method determineReaderName
 */
be.belgium.eid.CardReader.prototype.determineReaderName = function() {
	// No reader name provided, use default reader name or reader name defined as applet parameter
	if (this.readerName === null || this.readerName === "") {
		var parameterReaderName = "" + this.getBEIDApplet().getParameter("Reader");
		if (parameterReaderName === null || parameterReaderName === "") {
			// Reader name is not defined as applet parameter
			this.readerName = this.getDefaultReaderName();
		} else {
			this.readerName = parameterReaderName;
		}
	}
};

/**
 * Check if card is present.
 * @public
 * @method isCardPresent
 * @return true if card is present, false if no card is present or if failed to detect.
 * @type primitive boolean
 */
be.belgium.eid.CardReader.prototype.isCardPresent = function() {
	var cardPresent = false;

	this.determineReaderName();

	if (this.readerName !== "") { // reader name is determined
		try {
			cardPresent = this.BEIDApplet.isCardPresent(this.readerName);
		} catch (e){} // catch Javascript and Java exceptions
	}
	return cardPresent;
};

/** 
 * @private
 * @method validChipNumber
 * @return true if valid chipnumber, false if no valid chipnumber
 * @type primitive boolean
 */
be.belgium.eid.CardReader.validChipNumber = function(chipNumber) {
	try {
		chipNumber = be.belgium.eid.JavaObjectConvertor.toString(chipNumber);
		if (chipNumber.length == 0) {
			return false;
		} else {
			return true;
		}
	} catch (e) {
		return false;
	}
};

/**
 * Read eID card or SIS card
 * @public
 * @method read
 * @return a EIDCard or SISCard object or null if no card is present or there was a failure to read the card.
 * @type EIDCard,SISCard,null
 */
be.belgium.eid.CardReader.prototype.read = function() {
	var card = null;
	var cardBuilder = null;

	try {
		// Reset all objects and previous read card values
		this.getBEIDApplet().InitLib(null);

		this.determineReaderName();

		// Still no reader name ...
		if (this.readerName === "") {
			if (this.noReaderDetectedHandler)
				this.noReaderDetectedHandler();

			try {
				this.getBEIDApplet().exitLib();
			} catch (e){}

			return null;
		}

		this.getBEIDApplet().InitLib(this.readerName);

		if (this.BEIDApplet.isCardPresent(this.readerName)) {
			if (be.belgium.eid.CardReader.validChipNumber(this.BEIDApplet.getChipNumber())) {
				cardBuilder = new be.belgium.eid.EIDCardBuilder35(this.BEIDApplet.getCardNumber());
				cardBuilder.setChipNumber(this.BEIDApplet.getChipNumber());
				cardBuilder.setValidityDateBegin(this.BEIDApplet.getValidityDateBegin());
				cardBuilder.setValidityDateEnd(this.BEIDApplet.getValidityDateEnd());
				cardBuilder.setIssMunicipality(this.BEIDApplet.getIssMunicipality());
				cardBuilder.setNationalNumber(this.BEIDApplet.getNationalNumber());
				cardBuilder.setSurname(this.BEIDApplet.getSurname());
				cardBuilder.setFirstName(this.BEIDApplet.getFirstName());
				cardBuilder.setNationality(this.BEIDApplet.getNationality());
				cardBuilder.setBirthLocation(this.BEIDApplet.getBirthLocation());
				cardBuilder.setBirthDate(this.BEIDApplet.getBirthDate());
				cardBuilder.setSex(this.BEIDApplet.getSex());
				cardBuilder.setNobleCondition(this.BEIDApplet.getNobleCondition());
				cardBuilder.setSpecialStatus(this.BEIDApplet.getSpecialStatus());
				cardBuilder.setStreet(this.BEIDApplet.getStreet());
				cardBuilder.setStreetNumber(this.BEIDApplet.getStreetNumber());
				cardBuilder.setBoxNumber(this.BEIDApplet.getBoxNumber());
				cardBuilder.setZip(this.BEIDApplet.getZip());
				cardBuilder.setMunicipality(this.BEIDApplet.getMunicipality());
				cardBuilder.setCountry(this.BEIDApplet.getCountry());
				var pictureArray = this.BEIDApplet.GetPicture();
				if (typeof(pictureArray) == "function") {
					var fixPictureArray = new Array(pictureArray.length);
					for (var i = 0; i < fixPictureArray.length; i++) {
						fixPictureArray[i] = pictureArray[i];
					}
					cardBuilder.setPicture(fixPictureArray);
					fixPictureArray = null;
				} else {
					cardBuilder.setPicture(pictureArray);
				}
				pictureArray = null;
			} else { 
				// The applet does not return a chip number for SIS cards.
				cardBuilder = new be.belgium.eid.SISCardBuilder35();
				cardBuilder.setCardNumber(this.BEIDApplet.getCardNumber());
				cardBuilder.setValidityDateBegin(this.BEIDApplet.getValidityDateBegin());
				cardBuilder.setValidityDateEnd(this.BEIDApplet.getValidityDateEnd());
				cardBuilder.setNationalNumber(this.BEIDApplet.getNationalNumber());
				cardBuilder.setSurname(this.BEIDApplet.getSurname());
				cardBuilder.setFirstName(this.BEIDApplet.getFirstName());
				cardBuilder.setInitials(this.BEIDApplet.getInitials());
				cardBuilder.setBirthDate(this.BEIDApplet.getBirthDate());
				cardBuilder.setSex(this.BEIDApplet.getSex());
			}

			card = cardBuilder.getCard();

		} else {
			if (this.noCardPresentHandler)
				this.noCardPresentHandler();
		}
	} catch (e) {
		if (e instanceof be.belgium.eid.NullPointerException) {
			if (this.appletNotFoundHandler) {
				this.appletNotFoundHandler();
			} else {
				window.alert("BEID Applet not found.");
			}
		} else {
			if (this.appletExceptionHandler) {
				if (this.appletExceptionHandler.length > 0)
					this.appletExceptionHandler(e);
				else
					this.appletExceptionHandler();
			} else {
				window.alert("BEID Applet throw exception: " + e);
			}
		}
	}

	try {
		this.getBEIDApplet().exitLib();
	} catch (e){}

	return card;
};

/**
 * Reset applet. The picture shown in the applet will be cleared.
 * @public
 * @method reset
 */
be.belgium.eid.CardReader.prototype.reset = function() {
	try {
		this.getBEIDApplet().InitLib(null);
	} catch (e){} // catch Javascript and Java exceptions
	try {
		this.getBEIDApplet().exitLib();
	} catch (e){} // catch Javascript and Java exceptions
};
