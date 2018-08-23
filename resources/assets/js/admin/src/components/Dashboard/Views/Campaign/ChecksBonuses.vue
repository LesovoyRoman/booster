<template>
    <div class="row">
        <div class="col-md-12">
            <div class="card campaign-card campaign-bonuses">

                <div class="form-group">
                    <div class="form-group-part part-sm">
                        <b-form-select size="sm" v-model="selectedBonuses" :options="selectBonuses" class="mb-3"></b-form-select>
                    </div>
                    <div class="form-group-part part-sm">
                        <b-form-select size="sm" v-model="selectedCampaigns" :options="campaigns" class="mb-3"></b-form-select>
                    </div>
                    <div class="form-group-part part-sm">
                        <b-form-select size="sm" v-model="selectedBloggers" :options="bloggers" class="mb-3"></b-form-select>
                    </div>
                </div>

                <div class="form-group">
                    <span class="data-line">
                        Checked: <span class="data-line-value">5555</span>
                    </span>
                    <span class="data-line">
                        To check: <span class="data-line-value">5555</span>
                    </span>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6 col-lg-4 col-sm-6 col-xs-12" v-for="(bonus, index) in bonuses">
                            <div class="card-elem-bonus">
                                <div class="block-img-elem"></div>
                                <div class="block-data-elem">
                                    <p>{{ bonus.nameProduct }}</p>
                                    <p>{{ bonus.whoGets }}</p>
                                    <p>{{ bonus.from }}</p>
                                    <p>{{ bonus.namePrise }}</p>
                                    <div class="block-status-elem">
                                        <div v-if="bonus.accepted">
                                            <p>Потдверждено</p>
                                        </div>
                                        <div class="btns_to_justify block_btns_bonus" v-else>
                                            <button class="reject_bonus custom_btn_form">Отклонить</button>
                                            <button class="custom_btn_form">Одобрить</button>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pagination-custom" id="pagination-custom">
                    <b-pagination size="sm" :limit="9" hide-goto-end-buttons :total-rows="100" v-model="currentPage" :per-page="10"></b-pagination>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                currentPage: 5,
                selectedBonuses: 1,
                selectedCampaigns: 1,
                selectedBloggers: 1,
                selectBonuses: [
                    {value: 1, text: 'All'},
                    {value: 2, text: 'Last month'}
                ],
                campaigns: [
                    {value: 1, text: 'All campaigns'},
                    {value: 2, text: 'Last month'}
                ],
                bloggers: [
                    {value: 1, text: 'All bloggers'},
                    {value: 2, text: 'Last month'}
                ],

                bonuses: [
                    {photoPath: '', nameProduct: 'Milk', accepted: false, whoGets: 'Jet Faker', from: 'Jet Faker', namePrise: 'Dodge Viper'},
                    {photoPath: '', nameProduct: 'Milk', accepted: false, whoGets: 'Jet Faker', from: 'Jet Faker', namePrise: 'Dodge Viper'},
                    {photoPath: '', nameProduct: 'Milk', accepted: false, whoGets: 'Jet Faker', from: 'Jet Faker', namePrise: 'Dodge Viper'},
                    {photoPath: '', nameProduct: 'Milk', accepted: false, whoGets: 'Jet Faker', from: 'Jet Faker', namePrise: 'Dodge Viper'},
                    {photoPath: '', nameProduct: 'Milk', accepted: false, whoGets: 'Jet Faker', from: 'Jet Faker', namePrise: 'Dodge Viper'},
                    {photoPath: '', nameProduct: 'Milk', accepted: false, whoGets: 'Jet Faker', from: 'Jet Faker', namePrise: 'Dodge Viper'},
                    {photoPath: '', nameProduct: 'Milk', accepted: false, whoGets: 'Jet Faker', from: 'Jet Faker', namePrise: 'Dodge Viper'}
                ]
            }
        }
    }
</script>