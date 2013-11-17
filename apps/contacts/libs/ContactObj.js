/**
 * Contact object
 * This object represents a single contact
 */
Contacts__ContactObj.prototype = new Packet();
function Contacts__ContactObj (packetId) {
    this.packetId = packetId;
    this.data = [
	{
	    "type": "text",
	    "id": "firstname",
	    "name": "CONTACTS__CONTACT__FIRSTNAME",
	    "description": "CONTACTS__CONTACT__FIRSTNAME__DESCRIPTION",
	},
	{
	    "type": "text",
	    "id": "lastname",
	    "name": "CONTACTS__CONTACT__LASTNAME",
	    "description": "CONTACTS__CONTACT__LASTNAME__DESCRIPTION",
	},
	{
	    "type": "date",
	    "id": "dateofbirth",
	    "name": "CONTACTS__CONTACT__DATEOFBIRTH",
	    "description": "CONTACTS__CONTACT__DATEOFBIRTH__DESCRIPTION",
	},
    ];

    /**
     * Get index of this object
     */
    this.getIndex = getIndex;
    function getIndex () {
	return {
	    "fk_packetId": this.packetId,
	    "type": "Contacts__ContactObj",
	};
    }

    /**
     * Save this object
     */
    this.save = function (success_cb, fail_cb, async) {
	var that = this;
	Contacts__ContactObj.prototype.save.apply(
	    this,
	    [
	    function (data) {
		JSunic.Boot.appIndex('contacts').addObj(that);
		if (typeof success_cb == 'function') success_cb(data);
	    },
	    fail_cb,
	    async
	    ]
	);
    }
};
