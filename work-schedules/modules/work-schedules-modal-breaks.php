<!-- Modal -->
<div class="modal fade" id="add_breaks" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="add_breaksTitle">Breaks Form</h2>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>
            <div class="modal-body">
                <style>
                    .modal-box {
                        background: white;
                        border-radius: 10px;
                        padding: 20px;
                        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                    }
                </style>
                <div class="d-flex justify-content-center align-items-center bg-light">
                    <div class="modal-box">
                        <h6 class="text-center">Break Type Details</h6>
                        <div id="breaks-create-table" class="table-responsive text-no-wrap">
                            <div class="visually-hidden container-fluid spinner-border spinner-border-lg d-flex align-items-center justify-content-center w-px-700 h-px-700" role="status"></div>
                        </div>
                        <div class="mt-3">
                            <button class="btn btn-success float-end" onclick="addBreakRowCreate()">Add a break type ▼</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-arrow-back bx-xs"></i>Close
                </button>
            </div>   
            
        </div>
    </div>
</div>