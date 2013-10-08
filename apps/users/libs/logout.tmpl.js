/**
 * Log user out
 */
function users__logout () {
    JSunic.User = new UserObj();

    // Logout
    JSunic.User.logout();

    return false;
}
