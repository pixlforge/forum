<template>
    <li class="nav-item dropdown" v-if="userLoggedIn">
        <a class="nav-link dropdown-toggle-custom" role="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i  class="fa fa-envelope-o" :class="{ 'active': isActive}"></i>
        </a>
        <div class="dropdown-menu notification-dropdown" aria-labelledby="dropdownMenuButton">

            <a class="dropdown-item notification-item" v-if="! this.notifications.length">No recent notification</a>
            <a class="dropdown-item notification-item"
               v-for="notification in notifications"
               v-text="notification.data.link"
               :href="notification.data.link"
               @click="markAsRead(notification)"></a>

            <div class="text-center" v-if="this.notifications.length">
                <a class="mark-all-as-read" href="" @click.prevent="markAllAsRead(this.notifications)">Mark all as read</a>
            </div>
        </div>
    </li>
</template>

<script>
    export default {
        data() {
            return {
                notifications: [],
                isActive: false
            }
        },

        computed: {
            userLoggedIn() {
                return window.App.user;
            }
        },

        created() {
            this.fetchNotifications();
        },

        methods: {
            fetchNotifications() {
                axios.get("/profiles/" + window.App.user.name + "/notifications")
                    .then(response => {
                        this.notifications = response.data;

                        this.checkNotifications();
                    });
            },

            markAsRead(notification) {
                axios.delete('/profiles/' + window.App.user.name + '/notifications/' + notification.id);
            },

            markAllAsRead() {
                for (let notification of this.notifications) {
                    axios.delete('/profiles/' + window.App.user.name + '/notifications/' + notification.id);
                }

                this.fetchNotifications();
            },

            checkNotifications() {
                this.isActive = this.notifications.length > 0;
            }
        }
    }
</script>

<style>
    .active {
        color: tomato;
    }

    .notification-dropdown {
        max-width: 30ch;
    }

    .notification-item {
        font-size: .75rem;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }

    .mark-all-as-read {
        font-size: .5rem !important;
        color: #2a88bd !important;
    }
</style>