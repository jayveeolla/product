export default {
    methods : {
        $role(roleName) {
            return this.$page.props.role.indexOf(roleName) !== -1;
        }
    }
}