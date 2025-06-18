<div class="container">
    <input type="hidden" name="wphh-product-nonce" value="<?php echo wp_create_nonce( 'wphh-product-nonce' ); ?>">
    <fieldset>
        <legend class="text-capitalize h6">Pricing and Cost:</legend>
        <div class="row align-items-center justify-content">
            <div class="col-6">
                <label for="id-production-cost" class="form-label">Production Cost:</label>
                <div class="input-group">
                    <span class="input-group-text mb-4" id="idg-production-cost" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Here you must inform the unit cost of production of this product, according to the sales unit."><i class="bi bi-info-circle-fill"></i></span>
                    <input type="text" class="form-control mb-4" name="production-cost" id="id-production-cost" placeholder="Enter the production cost">
                </div>
            </div>
            <div class="col-6">
                <label for="id-standard-price" class="form-label">Standard Price:</label>
                <div class="input-group">
                    <span class="input-group-text mb-4" id="idg-standard-price" data-bs-toggle="tooltip" data-bs-placement="bottom" title="The base sales price must be entered here and will be used if there is no specific table for the customer."><i class="bi bi-info-circle-fill"></i></span>
                    <input type="text" class="form-control mb-4" name="standard-price" id="id-standard-price" placeholder="Enter default price">
                </div>
            </div>
        </div>
        <hr>
    </fieldset>
    <fieldset>
        <legend class="text-capitalize h6">Unit and Packaging:</legend>
        <div class="row align-items-center justify-content">
            <div class="col-4">
                <label for="id-stock-sales-unit" class="form-label">Stock and Sales Unit:</label>
                <div class="input-group">
                    <span class="input-group-text mb-4" id="idg-stock-sales-unit" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Here you must inform how this product is sold and stocked."><i class="bi bi-info-circle-fill"></i></span>
                    <select name="stock-sales-unit" id="id-stock-sales-unit" class="form-control mb-4">
                        <option value="B6">Box of 6</option>
                        <option value="B12">Box of 12</option>
                        <option value="B24">Box of 24</option>
                        <option value="B48">Box of 48</option>
                        <option value="UN">Unit</option>
                    </select>
                </div>
            </div>
            <div class="col-4">
                <label for="id-package-units" class="form-label">Package Units:</label>
                <div class="input-group">
                    <span class="input-group-text mb-4" id="idg-package-units" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Here you must inform how many units are in each package."><i class="bi bi-info-circle"></i></span>
                    <input type="text" class="form-control mb-4" name="package-units" id="id-package-units" readonly>
                    <span class="input-group-text mb-4">Units</span>
                </div>
            </div>
            <div class="col-4">
                <label for="id-volume-unit" class="form-label">Volume Unit:</label>
                <div class="input-group">
                    <span class="input-group-text mb-4" id="idg-volume-unit" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Here you must enter an integer that represents the quantity of milliliters that are stored per unit of the product."><i class="bi bi-info-circle-fill"></i></span>
                    <input type="text" class="form-control mb-4" name="volume-unit" id="id-volume-unit" placeholder="ex. 250">
                    <span class="input-group-text mb-4">mL</span>
                </div>
            </div>
        </div>
        <hr>
    </fieldset>
    <fieldset>
        <legend class="text-capitalize h6">Product Type:</legend>
        <div class="align-items-center justify-content form-check form-switch col-4">
            <input class="form-check-input" type="checkbox" id="id-is-product" name="is-product" checked>
            <label class="form-check-label" for="id-is-product">Is Product</label>
        </div>
    </fieldset>
</div>
