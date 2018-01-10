<template lang="pug">
  .app-sidebar 
    .app-sidebar-header 
      
    .app-sidebar-columns
      .app-sidebar-container 
        .app-sidebar-column
          .navigator 
            ul 
              li.spacer Projects
              li <a href=""># Harooo</a>
              li <a href=""># Harooo</a>
              li <a href=""># Harooo</a>
              li <a href=""># Harooo</a>
              li <a href=""># Harooo</a>
            ul
              li.spacer Settings
</template>

<script>
export default {
  name: 'AppSidebar'
}
</script>


<style lang="scss" scoped>
  ul {
    padding: 0px;

    li.spacer {
      padding: 3px 10px;
      font-weight: bold;
    }
  }

  ul > li > a {
    padding: 3px 10px;
    display: block;
    color: #72787a;
    &:hover {
      background-color: lightblue;
      text-decoration: none;
    }
  }
</style>
