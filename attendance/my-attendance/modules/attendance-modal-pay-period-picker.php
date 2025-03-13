<!-- Modal -->
<div class="modal fade" id="pay-period-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="pay-period-modalTitle">Daily Time Record Form</h2>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>
            
            <div class="modal-body">
                <div class="divider text-start">
                    <div class="divider-text">
                        
                    </div>
                </div>
                <form onsubmit="event.preventDefault();" id="pay-period-form">
                    <div class="mb-3">
                        <label for="pay_period" class="form-label">Pay Period:</label>
                        <select class="selectize_pay_period form-select" id="pay_period" name="pay_period" required></select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            <i class="bx bx-arrow-back bx-xs"></i>Close
                        </button>
                        <button type="submit" class="btn btn-success" onclick="downloadDTR();"><i class="bx bx-file bx-xs"></i>Download</button>
                    </div>
                </form>
            </div>
            
                
                    
                
            
        </div>
    </div>
</div>
<style>
.selectize-control.selectize_pay_period .selectize-input > div .description {
  opacity: 0.8;
}
.selectize-control.selectize_pay_period .selectize-input > div .name + .description {
  margin-left: 5px;
}
.selectize-control.selectize_pay_period .selectize-input > div .description:before {
  content: "<";
}
.selectize-control.selectize_pay_period .selectize-input > div .description:after {
  content: ">";
}
.selectize-control.selectize_pay_period .selectize-dropdown .caption {
  font-size: 12px;
  display: block;
  color: #a0a0a0;
}
</style>

<script>
  $(document).ready(function () {
  const REGEX_EMAIL = "([a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@" + "(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?)";
  $(".selectize_pay_period").selectize({
      persist: false,
      maxItems: 1,
      placeholder: 'Select a pay period',
      allowEmptyOption: true,
      valueField: "id",
      labelField: "pay_date",
      searchField: ["pay_date", "pay_period_end_date", "pay_period_start_date"],
      options: payPeriodsRecords,
      render: {
      item: function (item, escape) {
          return (
          "<div>" +
          (item.pay_date
              ? '<span class="name">' + escape(moment(item.pay_period_start_date).format("MMMM D, YYYY") + " - " + moment(item.pay_period_end_date).format("MMMM D, YYYY")) + "</span>"
              : "") +
          (item.email_address
              ? '<span class="description">' + escape(item.pay_period_end_date) + "</span>"
              : "") +
          "</div>"
          );
      },
      option: function (item, escape) {
          var label = item.pay_date || item.pay_period_start_date;
          var caption = item.pay_date ? `${item.pay_period_start_date} - ${item.pay_period_end_date}` : null;
          return (
          "<div>" +
          '<span class="label">' +
          escape(moment(label).format("MMMM D, YYYY - dddd")) +
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