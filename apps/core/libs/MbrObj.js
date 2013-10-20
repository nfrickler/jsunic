/**
 * Mbr packet
 */
MbrObj.prototype = new Packet();
function MbrObj (packetId) {
    this.packetId = packetId;

    this.setPacketId = setPacketId;
    function setPacketId (path, email) {
	this.packetId = path+"?id="+encodeURIComponent(email);
    }
}
