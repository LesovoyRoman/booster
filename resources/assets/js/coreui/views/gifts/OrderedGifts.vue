<template>
    <div class="wrapper">
        <div class="animated fadeIn">
            <b-row>
                <b-col sm="12" md="12">
                    <h2 class="h2">{{ header }}</h2>
                </b-col>

                <b-col
                        sm="12"
                        md="12">
                    <b-card>
                        <b-tabs pills card>
                            <b-tab title="All" active>
                                <b-form-group>
                                    <b-input-group>
                                        <b-form-input v-model="filter" placeholder="Type name of gift"/>
                                        <b-input-group-append>
                                            <b-btn :variant="'primary'" :disabled="!filter" @click="filter = ''">Clear</b-btn>
                                        </b-input-group-append>
                                    </b-input-group>
                                </b-form-group>

                                <b-table
                                        :hover="false"
                                        :striped="false"
                                        :bordered="false"
                                        :small="true"
                                        :fixed="false"
                                        responsive="sm"
                                        :items="gifts"
                                        :fields="fields"

                                        :filter="filter"
                                        :sort-by.sync="sortBy"
                                        :sort-desc.sync="sortDesc"
                                        :sort-direction="sortDirection"
                                        @filtered="onFiltered"

                                        :current-page="currentPage"
                                        :per-page="perPage">
                                    <template slot="name" slot-scope="data">
                                        <div class="photo_gift-block">
                                            <keep-alive><img :src="data.item.photo" alt="photo_item" class="photo_gift_table"></keep-alive>
                                        </div>
                                        <div class="gift-name-block">
                                            {{ data.item.name }}
                                        </div>
                                    </template>
                                    <template slot="points" slot-scope="data">
                                        {{ data.item.points }} <span class="showsTableCards">points</span>
                                    </template>
                                    <template slot="code_status" slot-scope="data">
                                        <div v-if="data.item.code_status === ''">
                                            <b-button :variant="'primary'" class="">Add code</b-button>
                                        </div>
                                        <div v-if="data.item.code_status === 'sent'">
                                            <b-form-select dark v-model="selectedSent">
                                                <option slot="first" :value="'sent'">Sent</option>
                                                <option :value="'got'">Got</option>
                                            </b-form-select>
                                        </div>
                                        <div v-if="data.item.code_status === 'got'">
                                            <b-form-select dark v-model="selectedGot">
                                                <option slot="first" :value="'sent'">Sent</option>
                                                <option :value="'got'">Got</option>
                                            </b-form-select>
                                        </div>
                                    </template>
                                </b-table>

                                <nav>
                                    <b-pagination
                                            :total-rows="getRowCount(gifts)"
                                            :per-page="perPage"
                                            align="center"
                                            v-model="currentPage"
                                            prev-text="Prev"
                                            next-text="Next"
                                            hide-goto-end-buttons/>
                                </nav>

                            </b-tab>

                            <b-tab title="New">
                                <b-form-group>
                                    <b-input-group>
                                        <b-form-input v-model="filter" placeholder="Type name of gift"/>
                                        <b-input-group-append>
                                            <b-btn :variant="'primary'" :disabled="!filter" @click="filter = ''">Clear</b-btn>
                                        </b-input-group-append>
                                    </b-input-group>
                                </b-form-group>

                                <b-table
                                        :hover="false"
                                        :striped="false"
                                        :bordered="false"
                                        :small="true"
                                        :fixed="false"
                                        responsive="sm"
                                        :items="gifts"
                                        :fields="fields"

                                        :filter="filter"
                                        :sort-by.sync="sortBy"
                                        :sort-desc.sync="sortDesc"
                                        :sort-direction="sortDirection"
                                        @filtered="onFiltered"

                                        :current-page="currentPage"
                                        :per-page="perPage">
                                    <template slot="name" slot-scope="data">
                                        <div class="photo_gift-block">
                                            <keep-alive><img :src="data.item.photo" alt="photo_item" class="photo_gift_table"></keep-alive>
                                        </div>
                                        <div class="gift-name-block">
                                            {{ data.item.name }}
                                        </div>
                                    </template>
                                    <template slot="points" slot-scope="data">
                                        {{ data.item.points }} <span class="showsTableCards">points</span>
                                    </template>
                                    <template slot="code_status" slot-scope="data">
                                        <div v-if="data.item.code_status === ''">
                                            <b-button :variant="'primary'" class="">Add code</b-button>
                                        </div>
                                        <div v-if="data.item.code_status === 'sent'">
                                            <b-form-select dark v-model="selectedSent">
                                                <option slot="first" :value="'sent'">Sent</option>
                                                <option :value="'got'">Got</option>
                                            </b-form-select>
                                        </div>
                                        <div v-if="data.item.code_status === 'got'">
                                            <b-form-select dark v-model="selectedGot">
                                                <option slot="first" :value="'sent'">Sent</option>
                                                <option :value="'got'">Got</option>
                                            </b-form-select>
                                        </div>
                                    </template>
                                </b-table>

                                <nav>
                                    <b-pagination
                                            :total-rows="getRowCount(gifts)"
                                            :per-page="perPage"
                                            align="center"
                                            v-model="currentPage"
                                            prev-text="Prev"
                                            next-text="Next"
                                            hide-goto-end-buttons/>
                                </nav>
                            </b-tab>

                            <b-tab title="Sent">
                                <b-form-group>
                                    <b-input-group>
                                        <b-form-input v-model="filter" placeholder="Type name of gift"/>
                                        <b-input-group-append>
                                            <b-btn :variant="'primary'" :disabled="!filter" @click="filter = ''">Clear</b-btn>
                                        </b-input-group-append>
                                    </b-input-group>
                                </b-form-group>

                                <b-table
                                        :hover="false"
                                        :striped="false"
                                        :bordered="false"
                                        :small="true"
                                        :fixed="false"
                                        responsive="sm"
                                        :items="gifts"
                                        :fields="fields"

                                        :filter="filter"
                                        :sort-by.sync="sortBy"
                                        :sort-desc.sync="sortDesc"
                                        :sort-direction="sortDirection"
                                        @filtered="onFiltered"

                                        :current-page="currentPage"
                                        :per-page="perPage">
                                    <template slot="name" slot-scope="data">
                                        <div class="photo_gift-block">
                                            <keep-alive><img :src="data.item.photo" alt="photo_item" class="photo_gift_table"></keep-alive>
                                        </div>
                                        <div class="gift-name-block">
                                            {{ data.item.name }}
                                        </div>
                                    </template>
                                    <template slot="points" slot-scope="data">
                                        {{ data.item.points }} <span class="showsTableCards">points</span>
                                    </template>
                                    <template slot="code_status" slot-scope="data">

                                    </template>
                                </b-table>

                                <nav>
                                    <b-pagination
                                            :total-rows="getRowCount(gifts)"
                                            :per-page="perPage"
                                            align="center"
                                            v-model="currentPage"
                                            prev-text="Prev"
                                            next-text="Next"
                                            hide-goto-end-buttons/>
                                </nav>
                            </b-tab>

                            <b-tab title="Got">
                                <b-form-group>
                                    <b-input-group>
                                        <b-form-input v-model="filter" placeholder="Type name of gift"/>
                                        <b-input-group-append>
                                            <b-btn :variant="'primary'" :disabled="!filter" @click="filter = ''">Clear</b-btn>
                                        </b-input-group-append>
                                    </b-input-group>
                                </b-form-group>

                                <b-table
                                        :hover="false"
                                        :striped="false"
                                        :bordered="false"
                                        :small="true"
                                        :fixed="false"
                                        responsive="sm"
                                        :items="gifts"
                                        :fields="fields"

                                        :filter="filter"
                                        :sort-by.sync="sortBy"
                                        :sort-desc.sync="sortDesc"
                                        :sort-direction="sortDirection"
                                        @filtered="onFiltered"

                                        :current-page="currentPage"
                                        :per-page="perPage">
                                    <template slot="name" slot-scope="data">
                                        <div class="photo_gift-block">
                                            <keep-alive><img :src="data.item.photo" alt="photo_item" class="photo_gift_table"></keep-alive>
                                        </div>
                                        <div class="gift-name-block">
                                            {{ data.item.name }}
                                        </div>
                                    </template>
                                    <template slot="points" slot-scope="data">
                                        {{ data.item.points }} <span class="showsTableCards">points</span>
                                    </template>
                                    <template slot="code_status" slot-scope="data">

                                    </template>

                                </b-table>

                                <nav>
                                    <b-pagination
                                            :total-rows="getRowCount(gifts)"
                                            :per-page="perPage"
                                            align="center"
                                            v-model="currentPage"
                                            prev-text="Prev"
                                            next-text="Next"
                                            hide-goto-end-buttons/>
                                </nav>
                            </b-tab>
                        </b-tabs>
                    </b-card>
                </b-col>
            </b-row>
        </div>
    </div>
</template>

<script>
    let vm = {};

    export default {
        name: 'OrderedGifts',
        data(){
            return {
                header: 'Ordered gifts',

                currentPage: 1,
                perPage    : 10,
                totalRows  : 0,

                selectedGot: 'got',
                selectedSent: 'sent',

                filter: null,
                sortDirection: 'asc',
                sortBy: null,
                sortDesc: false,

                gifts: [
                    { id: 1, photo: '../images/6.jpg', name: 'Iphone 8', points: 10000, influencer: 'Joseph Stalin', phone: '+380999999999', code: '999999999', code_status: 'got'},
                    { id: 2, photo: '../images/7.jpg', name: 'Iphone 7', points: 20000, influencer: 'Adolf Hitler', phone: '+380999999999', code: '999999999', code_status: 'sent'},
                    { id: 3, photo: '../images/8.jpg', name: 'Iphone 7', points: 20000, influencer: 'Adolf Hitler', phone: '+380999999999', code: '', code_status: ''},
                ],

                fields: [
                    { key: 'name', sortable: true, 'class': 'name_gift' },
                    { key: 'points', sortable: true, 'class': 'points_gift' },
                    { key: 'influencer', sortable: true, 'class': 'influener_gift' },
                    { key: 'phone', sortable: false, 'class': 'phone_gift' },
                    { key: 'code', sortable: false, 'class': 'code_gift' },
                    { key: 'code_status', sortable: true, 'class': 'code_status_gift table_label_hidden' }
                ],
            }
        },
        computed: {
            sortOptions () {
                // Create an options list from our fields
                return this.fields
                    .filter(f => f.sortable)
                    .map(f => { return { text: f.label, value: f.key } })
            },
        },
        created(){
            vm = this;
        },
        methods: {
            onFiltered (filteredItems) {
                // Trigger pagination to update the number of buttons/pages due to filtering
                this.totalRows = filteredItems.length
                this.currentPage = 1
            },
            getRowCount(items){
                return items.length
            },
        },
    }
</script>