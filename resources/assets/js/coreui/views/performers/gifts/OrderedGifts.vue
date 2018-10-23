<template>
    <div class="wrapper">
        <div class="animated fadeIn">
            <b-row>
                <b-col sm="12" md="12">
                    <h2 class="h2">{{ header }}</h2>
                </b-col>

                <b-col>
                    <loading v-if="loading" style="position: fixed; z-index: 9999; left: 0; top: 0; height: 100%; width: 100%; background: rgba(2,2,2,0.70);"></loading>
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

                                        :current-page="currentPageAll"
                                        :per-page="perPage">
                                    <template slot="name" slot-scope="data">
                                        <div class="photo_gift-block">
                                            <keep-alive>
                                                <img v-if="data.item.images.length !== 0" :src="storage_path + '/' + data.item.images[0].image_path" alt="photo" class="photo_gift_table">
                                                <img v-else :src="storage_path + '/' + noimage" alt="photo" class="photo_gift_table">
                                            </keep-alive>
                                        </div>
                                        <div class="gift-name-block">
                                            {{ data.item.name }}
                                        </div>
                                    </template>
                                    <template slot="points" slot-scope="data">
                                        {{ data.item.points }} <span class="showsTableCards">points</span>
                                    </template>
                                    <template slot="status" slot-scope="data">
                                        <div>
                                            <select name="" id="" class="form-control custom-select" v-model="data.item.status" @change="changeStatusGift(data.item.id, data.item.status).then(function(response) { data.item.status = response }).catch(function(err){  })">
                                                <option v-for="status in statuses" :value="status">{{ status }}</option>
                                            </select>
                                        </div>
                                    </template>
                                </b-table>

                                <nav>
                                    <b-pagination
                                            :total-rows="getRowCount(gifts)"
                                            :per-page="perPage"
                                            align="center"
                                            v-model="currentPageAll"
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
                                        :sort-by="'updated_at'"
                                        :sort-desc="true"
                                        @filtered="onFiltered"

                                        :current-page="currentPageNew"
                                        :per-page="perPage">
                                    <template slot="name" slot-scope="data">
                                        <div class="photo_gift-block">
                                            <keep-alive>
                                                <img v-if="data.item.images.length !== 0" :src="storage_path + '/' + data.item.images[0].image_path" alt="photo" class="photo_gift_table">
                                                <img v-else :src="storage_path + '/' + noimage" alt="photo" class="photo_gift_table">
                                            </keep-alive>
                                        </div>
                                        <div class="gift-name-block">
                                            {{ data.item.name }}
                                        </div>
                                    </template>
                                    <template slot="points" slot-scope="data">
                                        {{ data.item.points }} <span class="showsTableCards">points</span>
                                    </template>
                                    <template slot="status" slot-scope="data">
                                        <div>
                                            <select name="" class="form-control custom-select" v-model="data.item.status" @change="changeStatusGift(data.item.id, data.item.status).then(function(response) { data.item.status = response }).catch(function(err){  })">
                                                <option v-for="status in statuses" :value="status">{{ status }}</option>
                                            </select>
                                        </div>
                                    </template>
                                </b-table>

                                <nav>
                                    <b-pagination
                                            :total-rows="getRowCount(gifts)"
                                            :per-page="perPage"
                                            align="center"
                                            v-model="currentPageNew"
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
                                        :items="sortGifts('sent')"
                                        :fields="fields"

                                        :filter="filter"
                                        :sort-by.sync="sortBy"
                                        :sort-desc.sync="sortDesc"
                                        :sort-direction="sortDirection"
                                        @filtered="onFiltered"

                                        :current-page="currentPageSent"
                                        :per-page="perPage">
                                    <template slot="name" slot-scope="data">
                                        <div class="photo_gift-block">
                                            <keep-alive>
                                                <img v-if="data.item.images.length !== 0" :src="storage_path + '/' + data.item.images[0].image_path" alt="photo" class="photo_gift_table">
                                                <img v-else :src="storage_path + '/' + noimage" alt="photo" class="photo_gift_table">
                                            </keep-alive>
                                        </div>
                                        <div class="gift-name-block">
                                            {{ data.item.name }}
                                        </div>
                                    </template>
                                    <template slot="points" slot-scope="data">
                                        {{ data.item.points }} <span class="showsTableCards">points</span>
                                    </template>
                                </b-table>

                                <nav>
                                    <b-pagination
                                            :total-rows="sortGiftsLength('sent')"
                                            :per-page="perPage"
                                            align="center"
                                            v-model="currentPageSent"
                                            prev-text="Prev"
                                            next-text="Next"
                                            hide-goto-end-buttons/>
                                </nav>
                            </b-tab>

                            <b-tab title="Ordered">
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
                                        :items="sortGifts('ordered')"
                                        :fields="fields"

                                        :filter="filter"
                                        :sort-by.sync="sortBy"
                                        :sort-desc.sync="sortDesc"
                                        :sort-direction="sortDirection"
                                        @filtered="onFiltered"

                                        :current-page="currentPageOrdered"
                                        :per-page="perPage">
                                    <template slot="name" slot-scope="data">
                                        <div class="photo_gift-block">
                                            <keep-alive>
                                                <img v-if="data.item.images.length !== 0" :src="storage_path + '/' + data.item.images[0].image_path" alt="photo" class="photo_gift_table">
                                                <img v-else :src="storage_path + '/' + noimage" alt="photo" class="photo_gift_table">
                                            </keep-alive>
                                        </div>
                                        <div class="gift-name-block">
                                            {{ data.item.name }}
                                        </div>
                                    </template>
                                    <template slot="points" slot-scope="data">
                                        {{ data.item.points }} <span class="showsTableCards">points</span>
                                    </template>
                                </b-table>

                                <nav>
                                    <b-pagination
                                            :total-rows="sortGiftsLength('ordered')"
                                            :per-page="perPage"
                                            align="center"
                                            v-model="currentPageOrdered"
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
    import Loading from 'vue-loading-spinner/src/components/Circle8'

    export default {
        name: 'OrderedGifts',
        components: {
            Loading
        },
        data(){
            return {
                header: 'Ordered gifts',

                loading: false,

                storage_path: '',
                noimage: 'images/noimage.jpg',

                currentPageAll: 1,
                currentPageNew: 1,
                currentPageSent: 1,
                currentPageOrdered: 1,


                perPage    : 10,
                totalRows  : 0,

                filter: null,
                sortDirection: 'asc',
                sortBy: null,
                sortDesc: false,

                gifts: [],

                fields: [
                    { key: 'name', sortable: true, 'class': 'name_gift' },
                    { key: 'points', sortable: true, 'class': 'points_gift' },
                    { key: 'influencer', sortable: true, 'class': 'influener_gift' },
                    { key: 'phone', sortable: false, 'class': 'phone_gift' },
                    { key: 'code', sortable: false, 'class': 'code_gift' },
                    { key: 'status', sortable: true, 'class': 'status_gift table_label_hidden' }
                ],

                statuses: ['created', 'sent', 'ordered']
            }
        },
        computed: {
            sortOptions () {
                return this.fields
                    .filter(f => f.sortable)
                    .map(f => { return { text: f.label, value: f.key } })
            },
        },
        created(){
            vm = this;
            this.storage_path = this.$root.storage_path;
            this.loading = true;
            axios.post('/getAllGifts').then(response => {
                this.loading = false;
                if(response.data.gifts instanceof Array) {
                    this.gifts = response.data.gifts
                }
                if(response.data.errors){
                    vm.$swal('Unfortunately:', response.data.errors, 'error')
                }
            }).catch( err => {
                this.loading = false;
                console.log(err.message)
            })
        },
        methods: {
            changeStatusGift(id, statusItem){
                this.loading = true;
                return axios.post('/changeStatusGift', {
                    id_gift: id,
                    new_status: statusItem
                }).then(response => {
                    this.loading = false;
                    if(response.status === 200) {
                        vm.$notify({
                            type:  'success',
                            title: 'Changed successfully!',
                            text : response.data.new_status,
                        })
                        return response.data.new_status;
                    }
                    if (response.status === 206) {
                        vm.$notify({
                            type:  'danger',
                            title: 'Error',
                            text : response.data.response,
                        })
                        return false
                    }
                }).catch(err => {
                    reject(err)
                    this.loading = false;
                })
            },
            onFiltered (filteredItems) {
                // Trigger pagination to update the number of buttons/pages due to filtering
                this.totalRows = filteredItems.length

                this.currentPageAll = 1;
                this.currentPageNew = 1;
                this.currentPageSent = 1;
                this.currentPageOrdered = 1;
            },
            sortGifts(type){
                return this.gifts
                    .filter(f => f.status === type)
            },
            getRowCount(items){
                return items.length
            },
            sortGiftsLength(type){
                return this.gifts
                    .filter(f => f.status === type).length
            }
        },
    }
</script>