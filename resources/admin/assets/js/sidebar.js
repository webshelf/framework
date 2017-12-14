
new Vue({
    el: '#nav-sidebar',
    data: {
        isCollapsed: false,
    },
    // define methods under the `methods` object
    methods: {
        switchCollapse: function()
        {
            return this.isCollapsed = !this.isCollapsed;
        }
    }
});
