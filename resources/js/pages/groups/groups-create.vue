<template lang="pug">
  .groups-create
    .row 
      .col-md-4.col-md-offset-4
        .panel.panel-default 
          .panel-heading Create Group
          .panel-body 
            .form-group 
              label Name 
              input.form-control(type="text" v-model="group.name")
            .form-group 
              label Description 
              textarea.form-control(v-model="group.description")
            .form-group 
              .pull-right 
                button.btn.btn-primary(type="submit") Save group
              router-link.btn.btn-link(:to="{name: 'Groups'}") Cancel
</template>

<script>
import stub from '@/stores/stubs/group'
export default {
  name: "GroupsCreate",
  data () {
    return {
      group: Object.assign({}, stub)
    }
  }
}
</script>
