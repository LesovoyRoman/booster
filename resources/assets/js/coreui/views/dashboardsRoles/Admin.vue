<template>
    <div>
        <b-row>
            <b-col
                    sm="6"
                    lg="3">
                <b-card no-body
                        class="bg-info">
                    <b-card-body class="pb-0">
                        <h4 class="mb-0">555</h4>
                        <h5 class="mb-1">Users online</h5>
                    </b-card-body>
                    <card-line3-chart-example
                            :data="[78, 81, 80, 45, 34, 12, 40]"
                            colorBg="rgba(255,255,255,.5)"
                            class="chart-wrapper"
                            style="height:70px;"
                            height="70"/>
                </b-card>
            </b-col>
            <b-col
                    sm="6"
                    lg="3">
                <b-card no-body
                        class="bg-primary">
                    <b-card-body class="pb-0">
                        <h4 class="mb-0">9572</h4>
                        <h5 class="mb-1">All users</h5>
                    </b-card-body>
                    <card-line3-chart-example
                            :data="[35, 43, 56, 49, 68, 78, 80]"
                            colorBg="rgba(255,255,255,.5)"
                            class="chart-wrapper"
                            style="height:70px;"
                            height="70"/>
                </b-card>
            </b-col>
        </b-row>

        <div class="divider_custom"></div>

        <b-row>
            <b-col
                    sm="6"
                    lg="3">
                <b-card no-body
                        class="bg-warning">
                    <b-card-body class="pb-0">
                        <h4 class="mb-0">311</h4>
                        <h5 class="mb-1">All Influencers</h5>
                    </b-card-body>
                    <card-line3-chart-example
                            :data="[56, 36, 78, 36, 58, 70, 90]"
                            colorBg="rgba(255,255,255,.5)"
                            class="chart-wrapper"
                            style="height:70px;"
                            height="70"/>
                </b-card>
            </b-col>
        </b-row>

        <b-row>

            <b-col
                    sm="6"
                    lg="3">
                <div class="social-box linkedin">
                    <i class="fa fa-linkedin"/>
                    <div class="chart-wrapper">
                    </div>
                    <ul>
                        <li>
                            <strong>5</strong>
                            <span>influencers</span>
                        </li>
                        <li>
                            <strong>6974</strong>
                            <span>auditory</span>
                        </li>
                    </ul>
                </div><!--/.social-box-->
            </b-col>

            <b-col
                    sm="6"
                    lg="3">
                <div class="social-box google-plus">
                    <i class="fa fa-google-plus"/>
                    <div class="chart-wrapper">
                    </div>
                    <ul>
                        <li>
                            <strong>12</strong>
                            <span>influencers</span>
                        </li>
                        <li>
                            <strong>58439</strong>
                            <span>auditory</span>
                        </li>
                    </ul>
                </div><!--/.social-box-->
            </b-col>

            <b-col
                    sm="6"
                    lg="3">
                <div class="social-box facebook">
                    <i class="fa fa-facebook"/>
                    <div class="chart-wrapper">
                    </div>
                    <ul>
                        <li>
                            <strong>8</strong>
                            <span>influencers</span>
                        </li>
                        <li>
                            <strong>4932</strong>
                            <span>auditory</span>
                        </li>
                    </ul>
                </div><!--/.social-box-->
            </b-col>
            <b-col
                    sm="6"
                    lg="3">
                <div class="social-box twitter">
                    <i class="fa fa-twitter"/>
                    <div class="chart-wrapper">
                    </div>
                    <ul>
                        <li>
                            <strong>3</strong>
                            <span>influencers</span>
                        </li>
                        <li>
                            <strong>9473</strong>
                            <span>auditory</span>
                        </li>
                    </ul>
                </div><!--/.social-box-->
            </b-col>

        </b-row>

        <div class="divider_custom"></div>

    </div>
</template>

<script>
    let vm = {};

    import CardLine3ChartExample from './../dashboard/CardLine3ChartExample'

    export default {
        name: 'AdminDashboard',
        data(){
            return {}
        },
        components: {
            CardLine3ChartExample
        },
    }
</script>