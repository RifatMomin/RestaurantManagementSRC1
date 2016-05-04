/**
 * @description JS to save functions that are used by the control JS of the app. 
 * @author Victor Moreno
 * @version 1
 * @date 2016/05/21
 */

/**
 * @description Creates the local session for the user.
 * @param user the user to create the session, or the JSON data of the user
 * @author Victor Moreno
 * @version 1
 * @date 2016/05/21
 */
function createLocalSession(user) {
    if (typeof (Storage) === "undefined") {
        alert("Your browser is not compatible with sessions, upgrade your browser");
    } else {
        sessionStorage.setItem("connectedUser", JSON.stringify(user));
    }
}

/**
 * @description Deletes the local session form session storage
 * @date 2016/05/21
 * @version 1
 * @author Victor Moreno Garcia
 */
function deleteLocalSession() {
    if (typeof (Storage) === "undefined") {
        alert("Your browser is not compatible with sessions, upgrade your browser");
    } else {
        sessionStorage.removeItem("connectedUser");
    }
}


/**
 * @description Checks if the local session is opened
 * @date 2016/04/21
 * @version 1
 * @author Victor Moreno Garcia
 */
function checkLocalSession() {
    if (typeof (Storage) === "undefined") {
        alert("Your browser is not compatible with sessions, upgrade your browser");
    } else {
        if (sessionStorage.length > 0) {
            var objAux = JSON.parse(sessionStorage.getItem("connectedUser"));

            var user = new UserObj();
            user.construct(objAux.id, objAux.name, objAux.surname1, objAux.nick, objAux.password, objAux.address, objAux.telephone, objAux.mail, objAux.birthDate, objAux.entryDate, objAux.dropOutDate, objAux.active, objAux.image);

            if (!isNaN(user.getId())) {
                return true;
            } else {
                return false;
            }
        } else {

        }
    }
}

/**
 * @description Checks if the server session is opnened
 * @date 2016/04/24
 * @version 1
 * @author Victor Moreno Garcia
 */
function checkServerSession() {
    $.ajax({
        url: "MainController",
        method: "POST",
        asyn: true,
        data: {controllerType: 0, action: 204, JSONData: {none: ""}},
        dataType: "json",
        success: function (outPutData) {
            if (outPutData[0] === true) {
                createLocalSession(outPutData[1]);
                return true;
            } else {
                return false;
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert("There has been an error in the server, try later");
            console.log(xhr.status + "\n" + thrownError + " responseHTML:" + xhr.responseHTML);
            console.log("Failure args: ", arguments);
        }});


}


function showErrors(errors)
{
    var errorString = "";

    $.each(errors, function (index, error) {
        errorString += error + "\n";
    });
    
    alert(errorString);
}


function showNormalError(msg){
    alert(msg);
}

var getTodayDate = function () {
    var month;
    //Construct the date
    var dateAux = new Date();
    if ((dateAux.getMonth() + 1) < 10) {
        month = "0" + (dateAux.getMonth() + 1);
    } else {
        month = dateAux.getMonth();
    }
    var day = dateAux.getDate();

    if ((day) < 10) {
        day = "0" + (day);
    }


    var currentDate = dateAux.getFullYear() + "-" + month + "-" + day;

    return currentDate;
}
