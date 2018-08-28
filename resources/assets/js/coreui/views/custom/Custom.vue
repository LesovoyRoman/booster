<template>
    <div class="wrapper">
        <div class="animated fadeIn">
            <b-row>
                <b-col cols="12">
                    <b-card
                            header-tag="header"
                            footer-tag="footer">
                        <div slot="header">
                            <i class="fa fa-align-justify"/> <strong>Custom stuff</strong>
                        </div>
                        <b-breadcrumb :items="items"/>
                    </b-card>
                </b-col>
            </b-row>



            <b-row>
                <b-col
                        sm="6"
                        md="4">
                    <b-card header="Card title">
                        Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.
                    </b-card>
                </b-col>
                <b-col
                        sm="6"
                        md="4">
                    <b-card show-footer>
                        Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.
                        <div slot="footer">Card footer</div>
                    </b-card>
                </b-col>
            </b-row>


            <b-card
                    header-tag="header"
                    footer-tag="footer">
                <div slot="header">
                    <i class="fa fa-align-justify"/> <strong>Bootstrap Carousel</strong>
                    <div class="card-actions">
                        <a
                                href="https://bootstrap-vue.js.org/docs/components/carousel"
                                target="_blank"><small class="text-muted">docs</small></a>
                    </div>
                </div>
                <div>
                    <b-carousel
                            id="carousel1"
                            style="text-shadow: 1px 1px 2px #333;"
                            controls
                            indicators
                            background="#ababab"
                            :interval="4000"
                            img-width="1024"
                            img-height="480"
                            v-model="slide"
                            @sliding-start="onSlideStart"
                            @sliding-end="onSlideEnd"
                    >

                        <!-- Text slides with image -->
                        <b-carousel-slide
                                caption="First slide"
                                text="Nulla vitae elit libero, a pharetra augue mollis interdum."
                                img-src="https://lorempixel.com/1024/480/technics/2/"
                        />

                        <!-- Slides with custom text -->
                        <b-carousel-slide img-src="https://lorempixel.com/1024/480/technics/4/">
                            <h1>Hello world!</h1>
                        </b-carousel-slide>

                        <!-- Slides with image only -->
                        <b-carousel-slide img-src="https://lorempixel.com/1024/480/technics/8/"/>

                        <!-- Slides with img slot -->
                        <!-- Note the classes .d-block and .img-fluid to prevent browser default image alignment -->
                        <b-carousel-slide>
                            <img
                                    slot="img"
                                    class="d-block img-fluid w-100"
                                    width="1024"
                                    height="480"
                                    src="https://lorempixel.com/1024/480/technics/5/"
                                    alt="image slot">
                        </b-carousel-slide>

                        <!-- Slide with blank fluid image to maintain slide aspect ratio -->
                        <b-carousel-slide
                                caption="Blank Image"
                                img-blank
                                img-alt="Blank image">
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse
                                eros felis, tincidunt a tincidunt eget, convallis vel est. Ut pellentesque
                                ut lacus vel interdum.
                            </p>
                        </b-carousel-slide>

                    </b-carousel>

                    <p class="mt-4">
                        Slide #: {{ slide }}<br>
                        Sliding: {{ sliding }}
                    </p>

                </div>
            </b-card>


            <b-col
                    cols="12"
                    md="6">
                <b-card
                        header-tag="header"
                        footer-tag="footer">
                    <div slot="header">
                        <i class="fa fa-align-justify"/> <strong>Bootstrap Collapse</strong>
                        <div class="card-actions">
                            <a
                                    href="https://bootstrap-vue.js.org/docs/components/collapse"
                                    target="_blank"><small class="text-muted">docs</small></a>
                        </div>
                    </div>
                    <div>
                        <b-btn
                                v-b-toggle.collapse1
                                variant="primary">Toggle Collapse</b-btn>
                        <b-collapse
                                id="collapse1"
                                class="mt-2">
                            <b-card>
                                <p class="card-text">Collapse contents Here</p>
                                <b-btn
                                        v-b-toggle.collapse1_inner
                                        size="sm">Toggle Inner Collapse</b-btn>
                                <b-collapse
                                        id=collapse1_inner
                                class="mt-2">
                                <b-card>Hello!</b-card>
                        </b-collapse>
                </b-card>
                </b-collapse>
        </div>
        </b-card>
        </b-col>


        <b-col sm="6">
            <b-card>
                <div slot="header">
                    <strong>Credit Card</strong> <small>Form</small>
                </div>
                <b-row>
                    <b-col sm="12">
                        <b-form-group>
                            <label for="name">Name</label>
                            <b-form-input
                                    type="text"
                                    id="name"
                                    placeholder="Enter your name"/>
                        </b-form-group>
                    </b-col>
                </b-row>
                <b-row>
                    <b-col sm="12">
                        <b-form-group>
                            <label for="ccnumber">Credit Card Number</label>
                            <b-form-input
                                    type="text"
                                    id="ccnumber"
                                    placeholder="0000 0000 0000 0000"/>
                        </b-form-group>
                    </b-col>
                </b-row>
                <b-row>
                    <b-col sm="4">
                        <b-form-group >
                            <label for="month1">Month</label>
                            <b-form-select
                                    id="month1"
                                    :plain="true"
                                    :options="[1,2,3,4,5,6,7,8,9,10,11,12]"/>
                        </b-form-group>
                    </b-col>
                    <b-col sm="4">
                        <b-form-group>
                            <label for="year1">Year</label>
                            <b-form-select
                                    id="year1"
                                    :plain="true"
                                    :options="[2014,2015,2016,2017,2018,2019,2020,2021,2022,2023,2024,2025]"/>
                        </b-form-group>
                    </b-col>
                    <b-col sm="4">
                        <b-form-group>
                            <label for="cvv">CVV/CVC</label>
                            <b-form-input
                                    type="text"
                                    id="cvv"
                                    placeholder="123"/>
                        </b-form-group>
                    </b-col>
                </b-row>
            </b-card>
        </b-col>


        <b-card
                header-tag="header"
                footer-tag="footer">
            <div slot="header">
                <i class="fa fa-align-justify"/> <strong>Bootstrap Jumbotron</strong>
                <div class="card-actions">
                    <a
                            href="https://bootstrap-vue.js.org/docs/components/jumbotron"
                            target="_blank">
                        <small class="text-muted">docs</small>
                    </a>
                </div>
            </div>
            <div>
                <b-jumbotron
                        header="Bootstrap 4"
                        lead="Bootstrap 4 Components for Vue.js 2">
                    <p>For more information visit website</p>
                    <b-btn
                            variant="primary"
                            href="#">More Info</b-btn>
                </b-jumbotron>
            </div>
        </b-card>


        <b-card
                header-tag="header"
                footer-tag="footer">
            <div slot="header">
                <i class="fa fa-align-justify"/> <strong>Bootstrap Navbar</strong>
                <div class="card-actions">
                    <a
                            href="https://bootstrap-vue.js.org/docs/components/navbar"
                            target="_blank">
                        <small class="text-muted">docs</small>
                    </a>
                </div>
            </div>
            <b-navbar
                    toggleable="md"
                    type="dark"
                    variant="info">

                <b-navbar-toggle target="nav_collapse"/>

                <b-navbar-brand href="#">NavBar</b-navbar-brand>

                <b-collapse
                        is-nav
                        id="nav_collapse">

                    <b-navbar-nav>
                        <b-nav-item href="#">Link</b-nav-item>
                        <b-nav-item
                                href="#"
                                disabled>Disabled</b-nav-item>
                    </b-navbar-nav>

                    <!-- Right aligned nav items -->
                    <b-navbar-nav class="ml-auto">

                        <b-nav-form>
                            <b-form-input
                                    size="sm"
                                    class="mr-sm-2"
                                    type="text"
                                    placeholder="Search"/>
                            <b-button
                                    size="sm"
                                    class="my-2 my-sm-0"
                                    type="submit">Search</b-button>
                        </b-nav-form>

                        <b-nav-item-dropdown
                                text="Lang"
                                right>
                            <b-dropdown-item href="#">EN</b-dropdown-item>
                            <b-dropdown-item href="#">ES</b-dropdown-item>
                            <b-dropdown-item href="#">RU</b-dropdown-item>
                            <b-dropdown-item href="#">FA</b-dropdown-item>
                        </b-nav-item-dropdown>

                        <b-nav-item-dropdown right>
                            <!-- Using button-content slot -->
                            <template slot="button-content">
                                <em>User</em>
                            </template>
                            <b-dropdown-item href="#">Profile</b-dropdown-item>
                            <b-dropdown-item href="#">Signout</b-dropdown-item>
                        </b-nav-item-dropdown>
                    </b-navbar-nav>

                </b-collapse>
            </b-navbar>
        </b-card>


        <b-card
                header-tag="header"
                footer-tag="footer">
            <div slot="header">
                <i class="fa fa-align-justify"/> <strong>Bootstrap Pagination</strong>
                <div class="card-actions">
                    <a
                            href="https://bootstrap-vue.js.org/docs/components/pagination"
                            target="_blank">
                        <small class="text-muted">docs</small>
                    </a>
                </div>
            </div>
            <div>
                <h6>Default</h6>
                <b-pagination
                        size="md"
                        :total-rows="100"
                        v-model="currentPage"
                        :per-page="10"/>
                <br>

                <h6>Small</h6>
                <b-pagination
                        size="sm"
                        :total-rows="100"
                        v-model="currentPage"
                        :per-page="10"/>
                <br>

                <div class="d-sm-down-none">
                    <h6>Large</h6>
                    <b-pagination
                            size="lg"
                            :total-rows="100"
                            v-model="currentPage"
                            :per-page="10"/>
                    <br>
                </div>

                <div>currentPage: {{ currentPage }}</div>
            </div>
        </b-card>


        <b-card
                header-tag="header"
                footer-tag="footer">
            <div slot="header">
                <i class="fa fa-align-justify"/> <strong>Bootstrap Popovers</strong>
                <div class="card-actions">
                    <a
                            href="https://bootstrap-vue.js.org/docs/components/popovers"
                            target="_blank">
                        <small class="text-muted">docs</small>
                    </a>
                </div>
            </div>
            <b-row>
                <b-col cols="6">
                    <div class="my-3 text-center">
                        <b-btn
                                v-b-popover.hover="'I am popover content!'"
                                title="Popover Title">
                            Hover Me
                        </b-btn>
                    </div>
                </b-col>
                <b-col cols="6">
                    <div class="my-3 text-center">
                        <b-btn
                                id="popoverButton-open"
                                variant="primary">Button</b-btn>

                        <b-popover
                                show
                                target="popoverButton-open"
                                title="Popover">
                            I start <strong>open</strong>
                        </b-popover>
                    </div>
                </b-col>
            </b-row>
        </b-card>


        <b-row>
            <b-col lg="6">
                <c-table caption="<i class='fa fa-align-justify'></i> Simple Table"/>
            </b-col><!--/.col-->

            <b-col lg="6">
                <c-table
                        striped
                        caption="<i class='fa fa-align-justify'></i> Striped Table"/>
            </b-col><!--/.col-->
        </b-row><!--/.row-->

        <b-row>
            <b-col lg="6">
                <c-table
                        small
                        caption="<i class='fa fa-align-justify'></i> Condensed Table"/>
            </b-col><!--/.col-->

            <b-col lg="6">
                <c-table
                        fixed
                        bordered
                        caption="<i class='fa fa-align-justify'></i> Bordered Table"/>
            </b-col><!--/.col-->
        </b-row><!--/.row-->

        <b-row>
            <b-col sm="12">
                <c-table
                        hover
                        striped
                        bordered
                        small
                        fixed
                        caption="<i class='fa fa-align-justify'></i> Combined All Table"/>
            </b-col>
        </b-row>


        <b-col md="12">
            <b-card header="3d Switch">
                <c-switch
                        type="3d"
                        variant="primary"
                        :checked="true"/>
                &nbsp;&nbsp;&nbsp;
                <c-switch
                        type="3d"
                        variant="secondary"
                        :checked="true"/>
                &nbsp;&nbsp;&nbsp;
                <c-switch
                        type="3d"
                        variant="success"
                        :checked="true"/>
                &nbsp;&nbsp;&nbsp;
                <c-switch
                        type="3d"
                        variant="warning"
                        :checked="true"/>
                &nbsp;&nbsp;&nbsp;
                <c-switch
                        type="3d"
                        variant="info"
                        :checked="true"/>
                &nbsp;&nbsp;&nbsp;
                <c-switch
                        type="3d"
                        variant="danger"
                        :checked="true"/>
            </b-card>
        </b-col>

        <b-card
                header-tag="header"
                footer-tag="footer">
            <div slot="header">
                <i class="fa fa-align-justify"/> <strong>Bootstrap Tooltips</strong> <small><code>v-b-tooltip</code> directive</small>
                <div class="card-actions">
                    <a
                            href="https://bootstrap-vue.js.org/docs/components/tooltip"
                            target="_blank">
                        <small class="text-muted">docs</small>
                    </a>
                </div>
            </div>
            <b-row>
                <b-col cols="6">
                    <div class="text-center my-3">
                        <b-btn
                                v-b-tooltip.hover
                                title="I am a tooltip!">Hover Me</b-btn>
                    </div>
                </b-col>
                <b-col cols="6">
                    <div class="text-center my-3">
                        <b-btn
                                id="tooltipButton-2"
                                variant="primary">Button</b-btn>
                        <b-tooltip
                                show
                                target="tooltipButton-2">
                            I start open
                        </b-tooltip>
                    </div>
                </b-col>
            </b-row>
        </b-card>


        <b-col cols="12" >
            <b-card
                    header-tag="header"
                    footer-tag="footer">
                <div slot="header">
                    <i class="fa fa-align-justify"/> <strong>Bootstrap button group</strong>
                    <div class="card-actions">
                        <a
                                href="https://bootstrap-vue.js.org/docs/components/button-group"
                                target="_blank">
                            <small class="text-muted">docs</small>
                        </a>
                    </div>
                </div>
                <div>
                    <b-button-group>
                        <b-button>One</b-button>
                        <b-button>Two</b-button>
                        <b-button>Three</b-button>
                        <b-button>Four</b-button>
                        <b-button class="d-sm-down-none">Five</b-button>
                    </b-button-group>
                    <br><br>
                    <b-button-group>
                        <b-button
                                class="d-sm-down-none"
                                variant="success">Success</b-button>
                        <b-button variant="info">Info</b-button>
                        <b-button variant="warning">Warn</b-button>
                        <b-button
                                class="d-sm-down-none"
                                variant="primary">Primary</b-button>
                        <b-button variant="danger">Danger</b-button>
                        <b-button variant="link">Link</b-button>
                    </b-button-group>
                </div>
            </b-card>
        </b-col>


        <b-col
                cols="12"
                md="6">
            <b-card
                    header-tag="header"
                    footer-tag="footer">
                <div slot="header">
                    <i class="fa fa-align-justify"/> <strong>Bootstrap Dropdown</strong>
                    <div class="card-actions">
                        <a
                                href="https://bootstrap-vue.js.org/docs/components/dropdown"
                                target="_blank"><small class="text-muted">docs</small></a>
                    </div>
                </div>
                <div>
                    <b-dropdown
                            id="ddown1"
                            text="Dropdown Button"
                            class="m-2">
                        <b-dropdown-item>First Action</b-dropdown-item>
                        <b-dropdown-item>Second Action</b-dropdown-item>
                        <b-dropdown-item>Third Action</b-dropdown-item>
                        <b-dropdown-divider/>
                        <b-dropdown-item>Something else here...</b-dropdown-item>
                        <b-dropdown-item disabled>Disabled action</b-dropdown-item>
                    </b-dropdown>
                </div>
                <div>
                    <b-dropdown
                            id="ddown-buttons"
                            text="Dropdown using buttons as menu items"
                            class="m-2">
                        <b-dropdown-item-button>I'm a button</b-dropdown-item-button>
                        <b-dropdown-item-button>I'm also a button</b-dropdown-item-button>
                        <b-dropdown-item-button disabled>I'm a button, but disabled!</b-dropdown-item-button>
                        <b-dropdown-item-button>I don't look like a button, but I am!</b-dropdown-item-button>
                    </b-dropdown>
                </div>
                <div>
                    <b-dropdown
                            id="ddown-divider"
                            text="Dropdown with divider"
                            class="m-2">
                        <b-dropdown-item-button>First item</b-dropdown-item-button>
                        <b-dropdown-item-button>Second item</b-dropdown-item-button>
                        <b-dropdown-divider/>
                        <b-dropdown-item-button>Separated Item</b-dropdown-item-button>
                    </b-dropdown>
                </div>
                <div>
                    <b-dropdown
                            id="ddown-header"
                            text="Dropdown with header"
                            class="m-2">
                        <b-dropdown-header>Dropdown header</b-dropdown-header>
                        <b-dropdown-item-button>First item</b-dropdown-item-button>
                        <b-dropdown-item-button>Second Item</b-dropdown-item-button>
                    </b-dropdown>
                </div>
            </b-card>
        </b-col>


        <b-card-group
                columns
                class="card-columns cols-2">
            <b-card header="Line Chart">
                <div class="chart-wrapper">
                    <line-example/>
                </div>
            </b-card>
            <b-card header="Bar Chart">
                <div class="chart-wrapper">
                    <bar-example/>
                </div>
            </b-card>
            <b-card header="Doughnut Chart">
                <div class="chart-wrapper">
                    <doughnut-example/>
                </div>
            </b-card>
            <b-card header="Radar Chart">
                <div class="chart-wrapper">
                    <radar-example/>
                </div>
            </b-card>
            <b-card header="Pie Chart">
                <div class="chart-wrapper">
                    <pie-example/>
                </div>
            </b-card>
            <b-card header="Polar Area Chart">
                <div class="chart-wrapper">
                    <polar-area-example/>
                </div>
            </b-card>
        </b-card-group>
        </div>
    </div>
</template>

<script>
    import BarExample from './../charts/BarExample'
    import LineExample from './../charts/LineExample'
    import DoughnutExample from './../charts/DoughnutExample'
    import RadarExample from './../charts/RadarExample'
    import PieExample from './../charts/PieExample'
    import PolarAreaExample from './../charts/PolarAreaExample'

    export default {
        name: 'custom',
        components: {
            BarExample,
            LineExample,
            DoughnutExample,
            RadarExample,
            PieExample,
            PolarAreaExample,
        },
        data () {
            return {
                items: [{
                    text: 'base',
                    href: '#',
                }, {
                    text: 'custom',
                    href: '#',
                }],
            }
        },
    }
</script>
