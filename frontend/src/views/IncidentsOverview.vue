<template>
    <div>
        <table class='table table-responsive'>
            <thead class="thead-dark">
                <th>Time</th>
                <th>CI</th>
                <th>Smoke color</th>
                <th>Level</th>
                <th>City</th>
                <th>Street</th>
            </thead>
            <tr v-for='incident in incidents' :key='incident._id' @click="openIncident(incident._id)">
                <td>{{ incident.timestamp | ago }}</td>
                <td>{{ incident.report_id }}</td>
                <td><span class="smoke_color" :style="{ backgroundColor:incident.smoke_color }"></span></td>
                <td>{{ incident.grade }}</td>
                <td>{{ incident.city }}</td>
                <td>{{ incident.street }}</td>
            </tr>
        </table>
    </div>
</template>

<script>
import { SORT_INCIDENTS } from '@/shared/store/incidents/mutations.types';
import * as orderBy from 'lodash/orderBy';

export default {
  name: 'incidents-overview',
  mounted() {
    this.$store.dispatch('loadIncidents')
  },
  methods: {
    openIncident(id) {

    },
    sortIncidents(key) {
      this.$store.commit(SORT_INCIDENTS, key);
    },
  },
  computed: {
    // For now : automatically sort the incidents by timestamp
    incidents() {
      return orderBy(this.$store.state.incidents.all, ['timestamp'], 'desc');
    },
  },
};
</script>
