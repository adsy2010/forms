<template>
    
</template>

<script>
    import {API_BASE_URL} from "../config";

    export default {
        name: "Utility",
        description: "Contains reusable generic methods for use in multiple components.",
        methods:{

            /**
             * Retrieves all forms from the database with a given partial identifier
             *
             * @param name The partial name identifier to pickup forms
             * @returns {Promise<{}>} The form(s) the query has found
             */
            async getForms(name){
                let data = {};
                await axios({
                    method: 'get',
                    url: API_BASE_URL + '/form'
                }).then(response => {
                    data = response.data.data.filter((item)=>{
                        return item.name.toLowerCase().includes(name);
                    }); //just keeps items with time in the name
                }).catch(e =>{
                    return data; //return an empty object
                });
                return data;
            },

            /**
             * Commits a claim to the database
             *
             * @param formData Object format {form: integer, period: integer}
             * @returns {Promise<{}>} Returns the ID of the claim if successful, false otherwise
             */
            async makeClaim(formData) {
                let data = {};
                try {
                    await axios({
                        method: 'post',
                        url: API_BASE_URL + '/claim',
                        params: {remember_token: this.$root.getToken()},
                        data: {formId: formData.form, period: formData.period},
                    }).then(response => {
                        console.log(response);
                        data = (response.status === 200) ? response.data.data : {};
                    });
                }
                catch(exception)
                {
                    console.log(exception);
                    return data;
                }
                return data;
            },
        }
    }
</script>

<style scoped>

</style>