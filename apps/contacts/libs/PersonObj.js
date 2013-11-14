/**
 * Person object
 * This object represents a single person
 */
Contacts__PersonObj.prototype = new Packet();
function Contacts__PersonObj (packetId) {
    this.packetId = packetId;
    this.data = [
	{
	    "type": "text",
	    "id": "firstname",
	    "name": "CONTACTS__PERSON__FIRSTNAME",
	    "description": "CONTACTS__PERSON__FIRSTNAME__DESCRIPTION",
	},
	{
	    "type": "text",
	    "id": "lastname",
	    "name": "CONTACTS__PERSON__LASTNAME",
	    "description": "CONTACTS__PERSON__LASTNAME__DESCRIPTION",
	},
	{
	    "type": "date",
	    "id": "dateofbirth",
	    "name": "CONTACTS__PERSON__DATEOFBIRTH",
	    "description": "CONTACTS__PERSON__DATEOFBIRTH__DESCRIPTION",
	},
    ];

    /**
     * Get index of this object
     */
    this.getIndex = getIndex;
    function getIndex () {
	return {
	    "packetId": this.packetId,
	    "type": "Contacts__PersonObj",
	};
    }
};
