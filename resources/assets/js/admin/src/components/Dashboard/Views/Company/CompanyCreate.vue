<template>
    <div class="row">
        <div class="col-md-12">
            <div class="card create-company-card">
                <form action="" enctype="multipart/form-data">
                    <p class="pre-header-card">Common info</p>

                    <div class="form-group">
                        <label for="name_company" class="label_form_group">Name of company</label>
                        <input type="text" name="name_company" id="name_company" placeholder="Type your future name of company">
                    </div>
                    <div class="form-group">
                        <label for="id_company" class="label_form_group">ID company (can't be changed)</label>
                        <input type="text" name="id_company" id="id_company" placeholder="Type your future id of company">
                    </div>
                    <div class="form-group">
                        <div class="form-group-part part-sm">
                            <label for="company_ends" class="label_form_group">Company ends</label>
                            <b-form-select size="sm" v-model="selectedCompanyEnd" :options="companiesEnd" class="mb-3 select_width_auto"></b-form-select>
                        </div>
                        <div class="form-group-part part-sm">
                            <input type="date" name="date_company_ends" class="input_width_auto" id="company_ends" value="2001-01-01">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-group-part">
                            <p class="form-group-paragraph label_form_group">Country of company</p>
                            <input type="checkbox" id="all_countries" name="all_countries" hidden>
                            <label for="all_countries" class="label_checkbox">All countries</label>
                            <b-form-select size="sm" v-model="selectedCountry" :options="countries" class="mb-3"></b-form-select>
                        </div>
                        <div class="form-group-part">
                            <p class="form-group-paragraph label_form_group">City of company</p>
                            <input type="checkbox" id="all_cities" name="all_cities" hidden>
                            <label for="all_cities" class="label_checkbox">All cities</label>
                            <b-form-select size="sm" v-model="selectedCity" :options="citiesAll[selectedCountry]" class="mb-3"></b-form-select>
                        </div>
                    </div>

                    <div class="custom-divider-form"></div>

                    <p class="pre-header-card">Product of company</p>
                    <div class="form-group">
                        <label for="name_product" class="label_form_group">Name of product</label>
                        <input type="text" name="name_product" id="name_product" placeholder="Type your name of product">
                    </div>
                    <div class="form-group">
                        <p class="form-group-paragraph label_form_group">Product photo</p>
                        <label for="photo_product" class="label_form_group label_btn_upload custom_btn_form">Upload</label>
                        <input type="file" name="photo_product" id="photo_product" accept="image/*" hidden>
                    </div>
                    <div class="form-group">
                        <div class="form-group-part part-sm">
                            <p class="form-group-paragraph label_form_group">Middle price</p>
                            <input type="text" id="middle_price_product" name="middle_price_product" placeholder="0.00">
                            <label for="middle_price_product" class="label_form_group"></label>
                        </div>
                        <div class="form-group-part part-sm">
                            <p class="form-group-paragraph label_form_group">Currency</p>
                            <b-form-select size="sm" v-model="selectedCurrency" :options="currencies" class="mb-3"></b-form-select>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <label for="amount_points_product" class="label_form_group">Amount of points for 1 product</label>
                        <input type="text" name="amount_points_product" id="amount_points_product" placeholder="0">
                    </div>

                    <div class="custom-divider-form"></div>

                    <p class="pre-header-card">Additional info</p>
                    <div class="form-group">
                        <div class="form-group-part noneFloat">
                            <label for="company_ends" class="label_form_group">Checking type</label>
                            <b-form-select size="sm" v-model="selectedCheckingType" :options="checkingType" class="mb-3 select_width_auto"></b-form-select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="conditions_company" class="label_form_group">Conditions</label>
                        <textarea name="conditions_company" id="conditions_company" placeholder="Type conditions of company"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="instruction_blogers" class="label_form_group">Instruction for blogers</label>
                        <textarea name="instruction_blogers" id="instruction_blogers" placeholder="Type instruction"></textarea>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="custom_btn_form floatRight">Create</button>
                        <div class="clearfix"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script>

    export default {
        data() {
            return {
                citiesAll: {
                    1: [ // Brazil
                        {value: 1, text: 'São Paulo'},
                        {value: 2, text: 'Rio de Janeiro'},
                        {value: 3, text: 'Brasília'}
                    ],
                    2: [ // Argentina
                        {value: 1, text: 'Buenos Aires'},
                        {value: 2, text: 'Córdoba'},
                        {value: 3, text: 'Rosario'},
                    ],
                    3: [ // Peru
                        {value: 1, text: 'Lima'},
                        {value: 2, text: 'Arequipa'},
                        {value: 3, text: 'Trujillo'},
                    ]
                },
                countries: [
                    { value: 1, text: 'Brazil' },
                    { value: 2, text: 'Argentina' },
                    { value: 3, text: 'Peru' },
                ],
                companiesEnd: [
                    { value: 'Date', text: 'Date' },
                ],
                currencies: [
                    { value: 1, text: 'RUB' },
                    { value: 2, text: 'EUR' },
                    { value: 3, text: 'USD' },
                ],
                checkingType: [
                    { value: 1, text: 'Type serial number' },
                    { value: 2, text: 'QR code' },
                ],
                selectedCheckingType: 1,
                selectedCurrency: 1,
                selectedCountry: 1,
                selectedCity: 1,
                selectedCompanyEnd: 'Date',

            }
        },
        methods: {
            sendRefer(opt){
                this.$refs.dropdown.clickDropDown(opt);
            },
            endCompany(opt) {
                this.sendRefer(opt);
            },
            selectCountry(opt){
                opt === 'Ukraine' ?
                    cities = {1: 'Kharkov', 2: 'Kiev', 3: 'Odessa'} : cities;
                opt === 'Russia' ?
                    cities = {1: 'Moscow', 2: 'Saint Petersburg', 3: 'Ufa'} : cities;
                opt === 'Belarus' ?
                    cities = {1: 'Minsk', 2: 'Molodechno', 3: 'Borisov'} : cities;

                this.sendRefer(opt);
            },
        },
        created() {
            //console.log(this.citiesAll[1]);
        }
    }

</script>
<style>

</style>
