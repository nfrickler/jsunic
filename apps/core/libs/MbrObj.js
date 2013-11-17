/**
 * Mbr packet
 */
MbrObj.prototype = new Packet();
function MbrObj (packetId) {
    this.packetId = packetId;

    this.setPacketId = function (path, email) {
	this.packetId = path+"?id="+encodeURIComponent(email);
    }
}
