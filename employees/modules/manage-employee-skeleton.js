function loadSkeletonView(cards = 5, targetTableId) {
    let container = targetTableId;
    
    // Generate skeleton cards
    for (let i = 0; i < cards; i++) {
        console.log("card loading");
        let card = `
            <div class="card p-3 col-auto mx-3 my-3">
                <span class="display-6 skeleton-loader">#${i + 1}</span>
                <hr/>m
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="placeholder-img skeleton-loader">
                            
                        </div>
                        <div class="ms-3">
                            <p class="mb-1 skeleton-loader"></p>
                            <p class="mb-1 skeleton-loader"></p>
                            <p class="mb-1 skeleton-loader"></p>
                            <p class="mb-0 skeleton-loader"></p>
                        </div>
                    </div>
                    <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Actions
                    </button>
                </div>
                <hr class="mt-4 mb-4">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="skeleton-loader"></label>
                        <div class="border p-2 skeleton-loader">Loading...</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="skeleton-loader"></label>
                        <div class="border p-2 skeleton-loader"></div>
                    </div>
                    <div class="col-md-6">
                        <label class="skeleton-loader"></label>
                        <div class="border p-2 skeleton-loader"></div>
                    </div>
                    <div class="col-md-6">
                        <label class="skeleton-loader"></label>
                        <div class="border p-2 skeleton-loader"></div>
                    </div>
                </div>
            </div>
        `;
        container.innerHTML += card;
    }
}