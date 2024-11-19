
function Day(date: Date){
    return date.getDate().toString().padStart(2, '0');
}
function Month(date: Date){
    const numericMonth = ['01','02','03','04','05','06','07','08','09','10','11','12'];
    return numericMonth[date.getMonth()];
}
function Year(date: Date){
    return date.getFullYear();
}

function Hours(date: Date){
    return date.getHours().toString().padStart(2, '0');
}
function Minutes(date: Date){
    return date.getMinutes().toString().padStart(2, '0');
}
function Seconds(date: Date){
    return date.getSeconds().toString().padStart(2, '0');
}

function ToBrDate(date: Date){
    return Day(date) + "/" + Month(date) + "/" + Year(date)
}
function ToBrTime(date: Date){
    return Hours(date) + ":" + Minutes(date) 
}
function ToBrFullDate(date: Date){
    return Day(date) + "/" + Month(date) + "/" + Year(date) + " " + Hours(date) + ":" + Minutes(date) + ":" + Seconds(date);
}
function ToDefaultDate(date: Date, zeroSec: boolean = false){
    return Year(date) + "-" + Month(date) + "-" + Day(date) + " " + Hours(date) + ":" + Minutes(date) + ":" + (zeroSec ? "00" : Seconds(date));
}

export const FormatDate = {
    Day: Day,
    Month: Month,
    Year: Year,

    Hours: Hours,
    Minutes: Minutes,
    Seconds: Seconds,

    ToBrDate: ToBrDate,
    ToBrTime: ToBrTime,
    ToBrFullDate: ToBrFullDate,
    ToDefaultDate: ToDefaultDate
}