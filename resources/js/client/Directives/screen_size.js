export default {
    data: function () {
        return {
            windowWidth: 0,
        }
    },
    computed: {
        $wSm: function () {
            if (this.windowWidth < 600) {
                return true;
            }
            return false;
        },
        $wMd: function () {
            if (this.windowWidth >= 768) {
                return true;
            }
            return false;
        },
        $wLg: function () {
            if (this.windowWidth >= 992) {
                return true;
            }
            return false;
        },
        $wXl: function () {
            if (this.windowWidth >= 1200) {
                return true;
            }
            return false;
        },

    },
    mounted() {
        this.$nextTick(() => {
            window.addEventListener('resize', this.onResize);
            this.windowWidth = window.innerWidth
        })
    },

    unmount() {
        window.removeEventListener('resize', this.onResize);
    },

    methods: {
        onResize() {
            this.windowWidth = window.innerWidth
        }
    }
}