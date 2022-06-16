export function getDate(): string {
    let dateObj = new Date();
    let month = getMonth(dateObj.getUTCMonth()); //months from 1-12
    let day = dateObj.getUTCDate();
    let year = dateObj.getUTCFullYear();

    return month + ' ' + day + ', ' + year;
}

function getMonth(month: number): string {
    const months = [
        'January',
        'February',
        'March',
        'April',
        'May',
        'June',
        'July',
        'August',
        'September',
        'October',
        'November',
        'December'
    ];

    return months[month];
}
