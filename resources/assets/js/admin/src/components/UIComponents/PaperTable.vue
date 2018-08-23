<template>
  <div>
    <!--<div class="header">
      <slot name="header">
        <h4 class="title">{{title}}</h4>
        <p class="category">{{subTitle}}</p>
      </slot>
    </div>-->
    <div class="content table-responsive">
      <table class="table" id="campaignsTable" :class="tableClass">
        <thead>
          <th v-for="column in columns">
            <span class="filter_high_low">{{column}}
              <button class="btn-high"></button>
              <button class="btn-low"></button>
            </span>
          </th>
        </thead>
        <tbody>
          <tr v-for="item in data">
            <td v-for="column in columns" v-if="column == 'Campaign' && hasValue(item, column)"><a href="" class="campaign_link">{{itemValue(item, column)}}</a></td>
            <td v-for="column in columns" v-if="hasValue(item, column) && column !== 'Campaign'">{{itemValue(item, column)}}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>
<script>
  let nameColumn;
  export default {
    props: {
      columns: Array,
      data: Array,
      type: {
        type: String, // striped | hover
        default: 'Striped'
      },
      title: {
        type: String,
        default: ''
      },
      subTitle: {
        type: String,
        default: ''

      }
    },
    computed: {
      tableClass () {
        return `table-${this.type}`
      }
    },
    methods: {
      hasValue (item, column) {
        nameColumn = column.replace(' ', '_').toLowerCase();
        return item[nameColumn] !== 'undefined'
      },
      itemValue (item, column) {
        nameColumn = column.replace(' ', '_').toLowerCase();
        return item[nameColumn]
      }
    },
  }

</script>
<style>

</style>
