export default { 
    props: {
        block: Object,
    },

    computed: {
        fields() { 
            return JSON.parse(this.block.content); 
        },
    },
};