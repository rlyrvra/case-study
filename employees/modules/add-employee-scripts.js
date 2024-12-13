function nextForm(page = 1){
    const form = document.getElementById('personal_information');
    if(!form.checkValidity()){
        return;
    }

    
}

function calculatePayroll(hourlyRate) {
    
    // Assumptions
    const hoursPerDay = 8;
    const daysPerWeek = 5;
    const weeksPerYear = 52;
    const daysPerYear = weeksPerYear * daysPerWeek;
    
    // Annually
    const annually = hourlyRate * hoursPerDay * daysPerYear;
    
    // Weekly
    const weekly = hourlyRate * hoursPerDay * daysPerWeek;
    
    // Monthly (assuming 4.33 weeks in a month on average)
    const monthly = weekly * 4.33;
    
    // Daily
    const daily = hourlyRate * hoursPerDay;
    
    // Semi-Monthly (typically 24 pay periods in a year)
    const semiMonthly = annually / 24;
    
    // Hourly (provided directly as input)
    const hourly = hourlyRate;
    
    // Bi-Weekly (2 weeks of work)
    const biWeekly = weekly * 2;
    
    // Per-Minute (since 1 hour = 60 minutes)
    const perMinute = hourlyRate / 60;
    
    return {
        annually,
        weekly,
        monthly,
        daily,
        semiMonthly,
        hourly,
        biWeekly,
        perMinute
    };
}

function samplePayroll(){
    hourlyRate = document.getElementById("hourlyRate").value;
    const payrollSample = calculatePayroll(hourlyRate);
    document.getElementById("annual").value = payrollSample.annually;
    document.getElementById("weekly").value = payrollSample.weekly;
    document.getElementById("monthly").value = payrollSample.monthly;
    document.getElementById("daily").value = payrollSample.daily;
    document.getElementById("semiMonthly").value = payrollSample.semiMonthly;
    document.getElementById("hour").value = payrollSample.hourly;
    document.getElementById("biWeekly").value = payrollSample.biWeekly;
    document.getElementById("perMinute").value = payrollSample.perMinute;
}



