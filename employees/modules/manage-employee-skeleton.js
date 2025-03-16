var skeletonLoaded = false;
function loadSkeletonView(cards = 5, targetTableId) {
    let container = targetTableId;
    
    // Generate skeleton cards
    for (let i = 0; i < cards; i++) {
        console.log("card loading");
        let card = `
            <div class="col">
                <div class="card border-0 p-3 shadow-sm">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <div class="rounded-circle skeleton-loader" style="width: 80px; height: 80px;"></div>
                        </div>
                        <div class="w-100">
                            <div class="skeleton-loader mb-2" style="height: 16px; width: 60%;"></div>
                            <div class="skeleton-loader mb-2" style="height: 14px; width: 50%;"></div>
                            <div class="skeleton-loader" style="height: 14px; width: 30%;"></div>
                        </div>
                    </div>

                    <hr class="my-3">

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="skeleton-loader mb-1" style="height: 12px; width: 40%;"></div>
                            <div class="skeleton-loader border p-2" style="height: 18px;"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="skeleton-loader mb-1" style="height: 12px; width: 40%;"></div>
                            <div class="skeleton-loader border p-2" style="height: 18px;"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="skeleton-loader mb-1" style="height: 12px; width: 40%;"></div>
                            <div class="skeleton-loader border p-2" style="height: 18px;"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="skeleton-loader mb-1" style="height: 12px; width: 40%;"></div>
                            <div class="skeleton-loader border p-2" style="height: 18px;"></div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="skeleton-loader" style="height: 14px; width: 50px;"></div>
                        <div class="skeleton-loader rounded" style="height: 30px; width: 80px;"></div>
                    </div>
                </div>
            </div>

        `;
        container.innerHTML += card;
    }
}