<!-- Breaks Form Modal -->
<div class="modal fade" id="add_breaks" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow-sm border-0">
            <div class="modal-header bg-light border-bottom">
                <h2 class="modal-title fs-5 fw-semibold text-info" id="add_breaksTitle">
                    <i class="bx bx-coffee"></i> Breaks Form
                </h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <form onsubmit="event.preventDefault()" id="breaks_create_form">

                    <!-- Table Section -->
                    <div id="breaks_table_section" class="table-responsive mt-4">
                        <h6 class="text-center fw-semibold">Break Type Details</h6>
                        <div id="breaks-create-table" class="table-responsive text-no-wrap">
                            <div class="visually-hidden container-fluid spinner-border spinner-border-lg d-flex align-items-center justify-content-center w-px-700 h-px-700" role="status"></div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-outline-secondary shadow-sm" onclick="addBreakRowCreate()">
                                <i class="bx bx-plus"></i> Add Break
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            
            <!-- Modal Footer -->
            <div class="modal-footer border-top bg-light">
                <button type="button" class="btn btn-outline-secondary shadow-sm" data-bs-dismiss="modal">
                    <i class="bx bx-arrow-back"></i> Close
                </button>
            </div>
            </form>
        </div>
    </div>
</div>

