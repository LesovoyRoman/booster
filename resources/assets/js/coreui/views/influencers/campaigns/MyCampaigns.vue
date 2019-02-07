<template>
    <div class="wrapper" id="myCampaigns">
        <div class="animated fadeIn">
            <b-row>
                <b-col sm="12" md="12">
                    <h2 class="h2">{{ header }}</h2>
                </b-col>

                <loading v-if="loading" style="position: fixed; z-index: 9999; left: 0; top: 0; height: 100%; width: 100%; background: rgba(2,2,2,0.70);"></loading>

                <b-col
                        sm="12"
                        md="12">
                    <b-card>

                        <b-form-group>
                            <b-input-group>
                                <b-form-input v-model="filter" placeholder="Search via campaigns"/>
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
                                :items="campaigns"
                                :fields="fields"

                                :filter="filter"
                                :sort-by.sync="sortBy"
                                :sort-desc.sync="sortDesc"
                                :sort-direction="sortDirection"
                                @filtered="onFiltered"
                                class="verticalTop"

                                :current-page="currentPage"
                                :per-page="perPage">
                            <template slot="name" slot-scope="data">
                                <router-link :id="id = data.item.campaign.id" :data="campaign = data.item.campaign" :to="{ name: 'ProfileCampaign', params: { campaign:campaign, id: id } }">{{ data.item.campaign.name }}</router-link>
                            </template>
                            <template slot="links" slot-scope="row">
                                <div v-for="(linkItem, index) in row.item.links" :key="'link_id_' + index"  v-if="row.item.links">
                                    <b-form-group class="groupLinksCampaigns">
                                        <div class="inlineBlock">
                                            <b-form-input v-model="row.item.links[index].bonus_link" placeholder="Link path"/>
                                            <b-btn :variant="'primary'" @click="removeLink(row.index, index)" class="uppercase float-right font500"><span>-</span></b-btn>
                                        </div>
                                    </b-form-group>
                                </div>
                                <b-btn :variant="'primary'" @click="addLink(row.item.links)" class="uppercase float-right font500"><span>+</span></b-btn>
                            </template>
                            <template slot="date" slot-scope="row">
                                {{ row.item.campaign.created_at }}
                            </template>

                            <!--<template slot="active" slot-scope="row">
                                <b-button size="sm"  @click="row.item.active = !row.item.active" class="custom_btn_change" :variant="'primary'">
                                    <i :class="row.item.active ? 'fa fa-stop-circle' : 'fa fa-play-circle'"></i>
                                </b-button>
                            </template>-->
                            <template slot="change" justified="center" slot-scope="row">
                                <b-button size="sm" class="custom_btn_change" :variant="'primary'">
                                    <i class="icon-pencil"></i>
                                </b-button>
                            </template>
                            <template slot="delete" justified="center" slot-scope="row">
                                <b-button size="sm" @click="removeElement(row)" class="custom_btn_change" :variant="'primary'">
                                    <i class="icon-close"></i>
                                </b-button>
                            </template>
                        </b-table>

                        <nav>
                            <b-pagination
                                    :total-rows="getRowCount(campaigns)"
                                    :per-page="perPage"
                                    align="center"
                                    v-model="currentPage"
                                    prev-text="Prev"
                                    next-text="Next"
                                    hide-goto-end-buttons/>
                        </nav>
                    </b-card>
                </b-col>
            </b-row>
        </div>
    </div>
</template>

<script>
    let vm = {};

    import Loading from 'vue-loading-spinner/src/components/Circle10'

    export default {
        name: 'CampaignsInfluencer',
        components: {
            Loading
        },
        data(){
            return {
                header: 'My campaigns',
                loading: false,

                filter: null,
                sortBy: null,
                sortDesc: false,
                sortDirection: 'asc',

                currentPage: 1,
                perPage    : 10,
                totalRows  : 0,

                campaigns: [],

                fields: [
                    { key: 'name', sortable: true, 'class': 'table_name' },
                    { key: 'links', sortable: false, 'class': 'table_links' },
                    { key: 'date', sortable: true, 'class': 'table_date', label: 'Started' },
                    { key: 'change', label: '', 'class': 'table_label_hidden' },
                    { key: 'delete', label: '', 'class': 'table_label_hidden' },
                ]
            }
        },
        created() {
            vm = this;
            this.loading = true;
            axios.post('/campaignInfluencerBonusLinks').then(response => {
                this.loading = false;
                if(response.data.links instanceof Array) {
                    this.campaigns = response.data.links;
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
            onFiltered (filteredItems) {
                this.totalRows = filteredItems.length
                this.currentPage = 1
            },
            getRowCount (items) {
                return items.length
            },
            addLink(obj){
                obj.push({path: '', gift: ''})
            },

            async removeLink(index, indexLink){
                let check = await vm.$root.check();
                if (check === true) {
                    vm.campaigns[index].links.splice(indexLink, 1)
                }
            },
            async removeElement(item) {
                let check = await vm.$root.check();
                if (check === true) {
                    vm.campaigns.splice(item.index, 1);
                }
            },
        }
    }
</script>