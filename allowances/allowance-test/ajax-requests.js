function fetchAll() {
    $.ajax({
        url: 'apiTest.php',
        method: 'POST',
        data: {
            action: 'fetchAll'
        },
        dataType: 'html',
        success(response) {
            $('#allowance_table').html(response);
        },
        error(xhr, status, error) {
            console.error("Error fetching departments:", error);
        }
    });
}

function create() {

    var name = $("#name").val();
    var amount = $("#amount").val();
    var isTaxable = $("#is_taxable").prop("checked");
    var frequency = $("#frequency").val();
    var description = $("#description").val();
    var status = $("#status").val();
    var effectiveDate = $("#effective_date").val();
    var endDate = $("#end_date").val();

    console.log(
        `Name: ${name}, 
        Amount: ${amount}, 
        Is Taxable: ${isTaxable}, 
        Frequency: ${frequency}, 
        Description: ${description}, 
        Status: ${status}, 
        Effective Date: ${effectiveDate}, 
        End Date: ${endDate}`
    );

    const allowanceData = {
        name: name,
        amount: amount,
        isTaxable: isTaxable,
        frequency: frequency,
        description: description,
        status: status,
        effectiveDate: effectiveDate,
        endDate: endDate
    };

    //return;
    $.ajax({
        url: 'apiTest.php',
        method: 'POST',
        data: {
            action: 'create',
            allowance: allowanceData
        },
        dataType: 'html',
        success(response) {
            $('#allowance_table').html(response);
            $('#allowance-form').trigger('reset');
            fetchAll();
        },
        error(xhr, status, error) {
            console.error("Error fetching departments:", error);
        }
    });
}