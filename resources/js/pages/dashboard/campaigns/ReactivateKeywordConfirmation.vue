<template>
    <Modal name="reactivate-keyword-confirmation" title-class="text-red-600" title="Reactivate keyword">
        <div class="mt-2">Are you sure you want to reactivate this keyword?</div>

        <div class="modal-action">
            <button @click="close" class="btn px-8">No</button>
            <button @click="submit" class="btn bg-red-600 border-red-700 hover:bg-red-700 hover:border-red-800" :class="{'px-10': requestPending}">
                <Spinner v-if="requestPending" :size="20" :border-width="3" color="#fff"></Spinner>
                <div v-else>Yes, I'm sure</div>
            </button>
        </div>
    </Modal>
</template>

<script>
import Modal from "@/components/Modal.vue";
import ModalService from "@/services/Modal";
import {useDashboardCampaignStore} from "@/stores/dashboard/campaign";
import GlobalNotification from "@/services/GlobalNotification";
import Spinner from "@/components/Spinner.vue";

export default {
    name: "ReactivateKeywordConfirmation",

    components: {Modal, Spinner},

    data() {
        return {
            requestPending: false,
        };
    },

    methods: {
        submit() {
            const keywordId = useDashboardCampaignStore().selected.keywordId;
            this.requestPending = true;

            axios.delete(route('dashboard.api.campaign.keyword.reactivate', keywordId))
                .then(({data}) => {
                    if (data.status === 'success') {
                        useDashboardCampaignStore().markKeywordAsReactivated(keywordId);
                        this.close();

                        GlobalNotification.info({title: 'Successful reactivation', message: 'You have successfully reactivated current keyword.', timeout: 7000});
                    } else {
                        GlobalNotification.error({title: 'Whoops, something went wrong', message: 'Failed to reactivate keyword, please contact support.'});
                    }
                })
                .catch(error => {
                    console.error('Failed to submit form', error);
                    GlobalNotification.error({title: 'Whoops, something went wrong', message: 'Please try again later.'});
                })
                .finally(() => this.requestPending = false);
        },

        close() {
            ModalService.close('reactivate-keyword-confirmation');
        },
    },
}
</script>
