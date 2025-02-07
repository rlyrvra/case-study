var skeletonLoaded = false;
function loadSkeletonView(cards = 5, targetTableId) {
    let container = targetTableId;
    
    // Generate skeleton cards
    for (let i = 0; i < cards; i++) {
        console.log("card loading");
        let card = `
            <div class="card p-3 col-4 mx-3 my-3">
                <div class="skeleton-loader"></div>
                <hr/>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center w-100">
                        <div class="rounded-circle placeholder-img skeleton-loader col-3 h-px-100">
                            
                        </div>
                        <div class="ms-3 col-9">
                            <div class="mb-1 skeleton-loader"></div>
                            <div class="mb-1 skeleton-loader"></div>
                            <div class="mb-1 skeleton-loader"></div>
                            <div class="mb-0 skeleton-loader"></div>
                        </div>
                    </div>
                </div>
                <hr class="mt-4 mb-4">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="skeleton-loader mb-1"></div>
                        <div class="border p-2 skeleton-loader"></div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="skeleton-loader mb-1"></div>
                        <div class="border p-2 skeleton-loader"></div>
                    </div>
                    <div class="col-md-6">
                        <div class="skeleton-loader mb-1"></div>
                        <div class="border p-2 skeleton-loader"></div>
                    </div>
                    <div class="col-md-6">
                        <div class="skeleton-loader mb-1"></div>
                        <div class="border p-2 skeleton-loader"></div>
                    </div>
                </div>
            </div>
        `;
        container.innerHTML += card;
    }
}