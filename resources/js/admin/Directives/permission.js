export default {
    methods : {
        $can(permissionName) {
            return this.$page.props.permission.indexOf(permissionName) !== -1;
        }
    }
}