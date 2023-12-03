let count = 1;
const actions = {
    "sendReminder": showReminder,
    "showBlock": showBlock,
    "sendWarning": sendWarning,
    "nothing": () => {
    }
}
timeLeft = document.getElementById("time-left");


function convertMinutesToString(minutes) {
    if (minutes === 0) {
        return '';
    } else if (minutes < 60) {
        return `${minutes}min`;
    } else {
        const hours = Math.floor(minutes / 60);
        const remainingMinutes = minutes % 60;
        return `${hours}h-${remainingMinutes}min`;
    }
}

async function checkNotifications() {
    try {

        const response = await $.ajax({url: '/api/notifications.php'});

        if (response.action in actions) {
            actions[response.action](response)
        } else {
            console.error(response.action + " :Action Not Found")
        }
        document.querySelectorAll('.time-left').forEach((element) => {
            element.innerText = convertMinutesToString(response.timeLeft ?? 0)
        })

    } catch (error) {
        console.error(error);
        console.error(error.responseText);
    }
}


async function extendReservation(reservation_id) {

    try {
        await $.ajax({
            data: {reservation_id: reservation_id, action: "extend"},
            type: 'GET',
            url: '/api/manage-reservation.php'
        });
        Swal.fire({
            icon: 'success',
            title: 'Your Reservation Was Extended Successfully',
            showConfirmButton: false,
            timer: 1500
        })
    } catch (error) {
        console.error(error)
        Swal.fire({
            icon: 'error',
            title: 'Something Went Wrong, Please Try Again Later',
            showConfirmButton: false,
            timer: 1500
        })
    }
}

async function cancelReservation(reservation_id) {
    try {
        const result = await $.ajax({
            data: {reservation_id: reservation_id, action: "cancel"},
            type: 'GET',
            url: '/api/manage-reservation.php'
        });
        await Swal.fire({
            icon: 'success',
            title: 'Your Reservation Was Canceled Successfully',
            showConfirmButton: false,
            timer: 1500
        })
        window.location.replace("/home.php");
    } catch (error) {
        console.error(error)
        Swal.fire({
            icon: 'error',
            title: 'Something Went Wrong, Please Try Again Later',
            showConfirmButton: false,
            timer: 1500
        })
    }

}

async function showReminder(response) {
    const canExtend = response.extensions < 3;
    const result = await Swal.fire({
        title: "Reminder!",
        text: "your reservation will expire in " + response.timeLeft + " minutes, " + (canExtend ? "if you still need extra time please click extend or ignore this message" : "you can't request any extension because you exceeded the allowed times"),
        confirmButtonText: "Extend",
        showConfirmButton: canExtend,
        showCancelButton: true,
        cancelButtonText: "Cancel",
        cancelButtonColor: '#d33',

    });
    //if user clicked on extend
    if (result.isConfirmed) {
        await extendReservation(response.reservation_id);
        return;
    }
    //if user clicked on cancel
    if (result.dismiss === "cancel") {
        await cancelReservation(response.reservation_id);
        return;
    }

}

async function sendWarning(response) {
    await Swal.fire({
        title: "Warning!",
        text: "your reservation will expire in " + response.timeLeft + " minutes, Please leave before the timer ends or you will be blocked with violation ticket",
        confirmButtonText: "OK",
    });
}


async function showBlock(response) {
    await Swal.fire({
        icon: "error",
        title: "Blocked!",
        text: "your reservation has been canceled for the following reason: " + response.reason,
        confirmButtonText: "OK",
    });
    window.location.replace("/home.php");
}


const minutesSpace = 0.08;
window.onload = () => {
    // run for the first time
    checkNotifications()
    //then run every minutesSpace
    setInterval(checkNotifications, (minutesSpace) * 60000);
}
