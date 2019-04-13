import { SET_INCIDENTS } from './mutations.types';
import axios from 'axios';

export default {
  loadIncidents({commit}) {
    axios.get('../data/incidents.json').then((res)=>{
      commit(SET_INCIDENTS,res.data)     
    })
  }
};
