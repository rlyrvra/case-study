
<!-- Modal -->
<div class="modal fade" id="assign_allowances_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="assign_allowances_modalTitle">Assign Allowances</h2>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>
            
            <div class="modal-body">
                <hr/>
                <form id="leave_type_form" onsubmit="event.preventDefault()">
                    <div class="row mb-4">
                        <label for="select_employee" class="form-label text-center"><strong class="display-5">Employee:</strong></label>
                        <select class="form-select selectize_select_employee" id="select_employee" name="select_Employee" placeholder="Select Employee" required onchange="fetchEmployeeAllowances();">
                        </select>
                    </div>
                    <hr/>
                    <div class="row mb-4 justify-content-center">
                        <button type="button" class="btn-lg btn-info col-auto mx-auto" 
                        data-bs-target="#allowance_entitlement_modal"
                        data-bs-toggle="modal" 
                        data-bs-dismiss="modal"
                        onclick="assignAllowanceName()"
                        >
                        <i class="bx bx-label bx-sm"></i>Assign Allowances</button>
                        <button type="button" class="btn-lg btn-primary col-auto mx-auto" 
                        onclick="fetchEmployeeAllowances()"
                        >
                        Fetch Employee Allowances</button>
                    </div>
                    <hr/>
                    <div class="container-fluid card pt-5 pb-3 mt-5">
                        <h5>Allowances of Employee </h5>
                        <div id="employee-allowances-table" class="table-responsive text-no-wrap">
                            <?php include __DIR__ . '/assign-allowances-table.php'; ?>
                        </div>
                    </div>
                
                    </hr>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" 
                        data-bs-dismiss="modal"
                        aria-label="Close"
                        >
                        <i class="bx bx-arrow-back bx-sm"></i>Close
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <?php include __DIR__ . '/assign-allowances-fetch-allowances.php'; ?>
        <?php include __DIR__ . '/assign-allowances-fetch-employees.php'; ?>
        <script>
            $(document).ready(function() {
                populateSelectEmployee(document.getElementById("select_employee"));
            });
        </script>

        <script>
        $(document).ready(function () {
        const REGEX_EMAIL = "([a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@" + "(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?)";
        $("#select_employee").selectize({
            persist: false,
            maxItems: 1,
            placeholder: 'Select an employee',
            allowEmptyOption: true,
            valueField: "id",
            labelField: "description",
            searchField: ["full_name", "email_address"],
            options: employees,
            render: {
            item: function (item, escape) {
                return (
                "<div>" +
                (item.full_name
                    ? '<span class="name">' + escape(item.full_name) + "</span>"
                    : "") +
                (item.description
                    ? '<span class="description">' + escape(item.email_address) + "</span>"
                    : "") +
                "</div>"
                );
            },
            option: function (item, escape) {
                var label = item.full_name || item.email_address;
                var caption = item.full_name ? item.email_address : null;
                return (
                "<div>" +
                '<span class="label">' +
                escape(label) +
                "</span>" +
                (caption
                    ? '<span class="caption">' + escape(caption) + "</span>"
                    : "") +
                "</div>"
                );
            },
            },
            createFilter: function (input) {
            var match, regex;

            // email@address.com
            regex = new RegExp("^" + REGEX_EMAIL + "$", "i");
            match = input.match(regex);
            if (match) return !this.options.hasOwnProperty(match[0]);

            // name <email@address.com>
            regex = new RegExp("^([^<]*)<" + REGEX_EMAIL + ">$", "i");
            match = input.match(regex);
            if (match) return !this.options.hasOwnProperty(match[2]);

            return false;
            },
            create: function (input) {
            if (new RegExp("^" + REGEX_EMAIL + "$", "i").test(input)) {
                return { email: input };
            }
            var match = input.match(
                new RegExp("^([^<]*)<" + REGEX_EMAIL + ">$", "i")
            );
            if (match) {
                return {
                email: match[2],
                name: $.trim(match[1]),
                };
            }
            alert("Invalid email address.");
            return false;
            },
        });
        });
        </script>

        <style>
            .selectize-control.selectize_select_employee .selectize-input > div .description {
            opacity: 0.8;
            }
            .selectize-control.selectize_select_employee .selectize-input > div .name + .description {
            margin-left: 5px;
            }
            .selectize-control.selectize_select_employee .selectize-input > div .description:before {
            content: "<";
            }
            .selectize-control.selectize_select_employee .selectize-input > div .description:after {
            content: ">";
            }
            .selectize-control.selectize_select_employee .selectize-dropdown .caption {
            font-size: 12px;
            display: block;
            color: #a0a0a0;
            }
            
        </style>
        
    </div>
</div>
<?php include __DIR__ . '/assign-allowances-allowance-entitlement.php'; ?>