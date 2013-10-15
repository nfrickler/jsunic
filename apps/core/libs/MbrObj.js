/**
 * Mbr packet
 */
MbrObj.prototype = new Packet();
function MbrObj (path, id) {
    this.path = path;
    this.id = id;
}
