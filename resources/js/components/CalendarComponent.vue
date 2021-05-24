<template>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Calendar</div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <form @submit.prevent="store">
                            <div class="form-group">
                                <label for="event">Event:</label>
                                <input type="text" id="event" class='form-control' placeholder="Event" v-model="form['event']">
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="from">From:</label>
                                        <input type="date" class='form-control' id="from" placeholder="From" v-model="form['from']">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="to">To:</label>
                                        <input type="date" class='form-control' id="to" placeholder="To" v-model="form['to']">
                                    </div>
                                </div>
                            </div>
                            <div class="weekdays">
                                <div class="cbox">
                                    <input type="checkbox" id="sun" v-model="form.weeks[0]">
                                    <label for="sun">Sun:</label>  
                                </div>  
                                <div class="cbox">
                                    <input type="checkbox" id="mon" v-model="form.weeks[1]">
                                    <label for="mon">Mon:</label>
                                </div>
                                <div class="cbox">
                                    <input type="checkbox" id="tue" v-model="form.weeks[2]">
                                    <label for="tue">Tue:</label>
                                </div>
                                <div class="cbox">
                                    <input type="checkbox" id="wed" v-model="form.weeks[3]">
                                <label for="wed">Wed:</label>
                                </div>
                                <div class="cbox">
                                    <input type="checkbox" id="thu" v-model="form.weeks[4]">
                                <label for="thu">Thu:</label>
                                </div>
                                <div class="cbox">
                                    <input type="checkbox" id="fri" v-model="form.weeks[5]">
                                    <label for="fri">Fri:</label>
                                </div>
                                <div class="cbox">
                                    <input type="checkbox" id="sat" v-model="form.weeks[6]">
                                    <label for="sat">Sat:</label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Save</button>
                            <button type="button" class="btn btn-danger" @click="destroy">reset</button>
                        </form>
                    </div>
                    <div class="col-md-8">
                        <h2>{{this.monthsList[this.monthsNow]}} {{this.yearNow}}</h2>
                        <div :class="getEvents(day) ? 'p-2 text-muted calendar-day bg-success':'p-2 text-muted calendar-day'"  v-for="day in days" v-show="days.length">
                            <div class="row">
                                <div class="col-md-3">
                                    <span class="day">{{day}}</span> &nbsp; <span class="week">{{getWeek(day)}}</span>
                                </div>
                                <div class="col-md-8">
                                    <span>{{getEvents(day)}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'
    export default {
        data(){
            return{
                monthsList:[
                    'January',
                    'February',
                    'March',
                    'April',
                    'May',
                    'June',
                    'July',
                    'August',
                    'September',
                    'October',
                    'November',
                    'December'
                ],
                weeksList:[
                    'Sun',
                    'Mon',
                    'Tue',
                    'Wed',
                    'Thu',
                    'Fri',
                    'Sat'
                ],
                monthsNow:null,
                yearNow:null,
                lastDay:null,
                days:[],
                form:{
                    weeks:[false,false,false,false,false,false,false]
                },
                myEvents:[]
            }
        },
        created() {
            this.fetch()
            const now = new Date()
            this.monthsNow = now.getMonth()
            this.yearNow = now.getFullYear()
            this.lastDay = new Date(this.yearNow, this.monthsNow+1, 0).getDate()
            for( let i = 1; i <= this.lastDay; i++){
                this.days.push(i)
            }
        },
        methods:{
            getWeek(day){
                let now = new Date(this.yearNow, this.monthsNow,day).getDay()
                return this.weeksList[now]
            },
            getEvents(day){
                let month = this.monthsNow + 1
                let monthFormat = month < 10 ? '0'+month:month
                let dayFormat = day < 10 ? '0'+day:day
                let finalFormat = this.yearNow +'-'+ monthFormat +'-'+dayFormat
                let found = this.myEvents.find((val) => {
                    return val.date == finalFormat
                })
                return found ? found.event:null
            },
            store(){
                axios.post('calendar',this.form)
                .then(response => {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Event Successfully Saved',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    this.myEvents = [...response.data]
                }).catch(e => {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: e.response.data.message,
                        showConfirmButton: false,
                        timer: 1500
                    })
                })
            },
            fetch(){
                
                axios.get('calendar')
                .then(response => {
                    this.myEvents = [...response.data]
                    console.log(this.myEvents)
                })
                
            },
            destroy(){
                axios.delete('calendar')
                .then(response => {
                    this.myEvents=[]
                    this.form = {
                        weeks:[false,false,false,false,false,false,false]
                    }
                })
            }
        }

    }
</script>
<style>
.weekdays{
    display: flex;
}
.cbox{
    flex: 1;
}
.calendar-day{
    border-bottom: 1px solid #ccc;
}
.bg-success{
    background-color: #EEFCEF !important;
}
</style>
