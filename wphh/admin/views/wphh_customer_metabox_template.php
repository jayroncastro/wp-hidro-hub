<div class="container">
    <input type="hidden" name="wphh-customer-nonce" value="<?php echo wp_create_nonce( 'wphh-customer-nonce' ); ?>">
    <fieldset>
        <legend class="text-capitalize h6">Type of person:</legend>
        <div class="row align-items-center justify-content text-center">
            <div class="col-6">
                <input type="radio" name="type-person" id="id-individual-person">
                <label for="id-individual-person" class="text-capitalize fw-bold">Individual personal</label>
            </div>
            <div class="col-6">
                <input type="radio" name="type-person" id="id-business">
                <label for="id-business" class="text-capitalize fw-bold">Business</label>
            </div>
        </div>
        <hr>
    </fieldset>
    <fieldset>
        <legend class="text-capitalize h6">Personal Data:</legend>
        <div class="row align-items-center justify-content">
            <div class="col-6">
                <label for="id-ssn" class="form-label">SSN:</label>
                <input type="text" class="form-control" name="ssn" id="id-ssn" placeholder="enter your SSN">
            </div>
            <div class="col-6">
                <label for="id-identity-card" class="form-label">Identity Card:</label>
                <input type="text" class="form-control" name="identity-card" id="id-identity-card" placeholder="enter your ID">
            </div>
        </div>
        <hr>
    </fieldset>
    <fieldset>
        <legend class="text-capitalize h6">Business Data:</legend>
        <div class="row align-items-center justify-content">
            <div class="col-6">
                <label for="id-ein" class="form-label">EIN:</label>
                <input type="text" class="form-control" name="ein" id="id-ein">
            </div>
            <div class="col-6">
                <label for="id-tax-id" class="form-label">Tax ID:</label>
                <input type="text" class="form-control" name="tax-id" id="id-tax-id">
            </div>
            <div class="col-12">
                <label for="id-fantasy-name" class="form-label">Fantasy Name:</label>
                <input type="text" class="form-control" name="fantasy-name" id="id-fantasy-name">
            </div>
        </div>
        <hr>
    </fieldset>
    <fieldset>
        <legend class="text-capitalize h6">Main Contact:</legend>
        <div class="row align-items-center justify-content">
            <div class="col-4">
                <label for="id-main-phone" class="form-label">Main Phone: *</label>
                <input type="text" class="form-control" name="main-phone" id="id-main-phone">
            </div>
            <div class="col-4">
                <label for="id-phone-notifications" class="form-label">Phone Notifications: *</label>
                <input type="text" class="form-control" name="phone-notifications" id="id-phone-notifications">
            </div>
            <div class="col-4">
                <label for="id-main-email" class="form-label">Main Email: *</label>
                <input type="text" class="form-control" name="main-email" id="id-main-email">
            </div>
        </div>
        <hr>
    </fieldset>
    <fieldset>
        <legend class="text-capitalize h6">Main Address:</legend>
        <div class="row align-items-center justify-content">
            <div class="col-9">
                <label for="id-place" class="form-label">Place: *</label>
                <input type="text" class="form-control" name="place" id="id-place">
            </div>
            <div class="col-3">
                <label for="id-zip-code" class="form-label">Zip Code: *</label>
                <div class="input-group">
                    <input type="text" class="form-control" name="zip-code" id="id-zip-code">
                    <div class="input-group-btn">
                        <button class="btn btn-default"><i class="bi bi-search"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row align-items-center justify-content">
            <div class="col-4">
                <label for="id-number" class="form-label">Number:</label>
                <input type="text" class="form-control" name="number" id="id-number">
            </div>
            <div class="col-4">
                <label for="id-complement" class="form-label">Complement:</label>
                <input type="text" class="form-control" name="complement" id="id-complement">
            </div>
            <div class="col-4">
                <label for="id-neighborhood" class="form-label">Neighborhood:</label>
                <input type="text" class="form-control" name="neighborhood" id="id-neighborhood">
            </div>
        </div>
        <div class="row align-items-center justify-content">
            <div class="col-4">
                <label for="id-city" class="form-label">City:</label>
                <input type="text" class="form-control" name="city" id="id-city">
            </div>
            <div class="col-4">
                <label for="id-state" class="form-label">State:</label>
                <input type="text" class="form-control" name="state" id="id-state">
            </div>
        </div>
        <input type="hidden" name="latitude" id="id-latitude">
        <input type="hidden" name="longitude" id="id-longitude">
        <hr>
    </fieldset>
    <fieldset>
        <legend class="text-capitalize h6">Commercial Data:</legend>
        <div class="row align-items-center justify-content">
            <div class="col-8">
                <label for="id-price-table" class="form-label">Price Table:</label>
                <input type="text" class="form-control" name="price-table" id="id-price-table">
            </div>
            <div class="col-4">
                <label for="id-responsible-seller" class="form-label">Responsible Seller:</label>
                <input type="text" class="form-control" name="responsible-seller" id="id-responsible-seller">
            </div>
        </div>
        <hr>
    </fieldset>
    <fieldset>
        <legend class="text-capitalize h6">Delivery Address:</legend>
        <div class="row align-items-center justify-content">
            <button class="col-2 btn btn-default"><i class="bi bi-building-add"></i> Add Address</button>
        </div>
        <div class="row align-items-end justify-content">
            <div class="col-9">
                <label for="id-place-delivery-address-1" class="form-label">Place: *</label>
                <input type="text" class="form-control" name="place-delivery-address-1" id="id-place-delivery-address-1">
            </div>
            <div class="col-3">
                <label for="id-zip-code-delivery-address-1" class="form-label">Zip Code:</label>
                <div class="input-group">
                    <input type="text" class="form-control" name="zip-code-delivery-address-1" id="id-zip-code-delivery-address-1">
                    <div class="input-group-btn">
                        <button class="btn btn-default"><i class="bi bi-search"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row align-items-center justify-content">
            <div class="col-3">
                <label for="id-number-delivery-address-1" class="form-label">Number:</label>
                <input type="text" class="form-control" name="number-delivery-address-1" id="id-number-delivery-address-1">
            </div>
            <div class="col-5">
                <label for="id-complement-delivery-address-1" class="form-label">Complement:</label>
                <input type="text" class="form-control" name="complement-delivery-address-1" id="id-complement-delivery-address-1">
            </div>
            <div class="col-4">
                <label for="id-neighborhood-delivery-address-1" class="form-label">Neighborhood:</label>
                <input type="text" class="form-control" name="neighborhood-delivery-address-1" id="id-neighborhood-delivery-address-1">
            </div>
        </div>
        <div class="row align-items-center justify-content">
            <div class="col-4">
                <label for="id-city-delivery-address-1" class="form-label">City:</label>
                <input type="text" class="form-control" name="city-delivery-address-1" id="id-city-delivery-address-1">
            </div>
            <div class="col-2">
                <label for="id-state-delivery-address-1" class="form-label">State:</label>
                <input type="text" class="form-control" name="state-delivery-address-1" id="id-state-delivery-address-1">
            </div>
            <input type="hidden" name="latitude-delivery-address-1" id="id-latitude-delivery-address-1">
            <input type="hidden" name="longitude-delivery-address-1" id="id-longitude-delivery-address-1">
            <hr>
        </div>
    </fieldset>
</div>