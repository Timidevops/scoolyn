    <div x-data="calender()" x-init="[initDate(), getNoOfDays()]" x-cloak>
      <div class="px-1 py-2">
        <div class="mb-5 w-64">
            <div class="bg-white  rounded-lg  p-2" style="width: 15rem">
              <span class="text-xs">Coming Events</span>
              <div class="flex justify-center items-center mb-2">
                <div>
                  <span x-text="MONTH_NAMES[month]" class="text-lg font-semibold text-gray-200"></span>
                  <span x-text="year" class="ml-1 text-base text-gray-200 font-semibold"></span>
                </div>
                
              </div>

              <div class="flex flex-wrap mb-3 -mx-1">
                <template x-for="(day, index) in DAYS" :key="index">
                  <div style="width: 14.29%" class="px-1">
                    <div x-text="day" class="text-gray-300 font-medium text-center text-xs"></div>
                  </div>
                </template>
              </div>

              <div class="flex flex-wrap -mx-1">
                <template x-for="blankday in blankdays">
                  <div style="width: 14.29%" class="text-center  p-1  text-sm"></div>
                </template>
                <template x-for="(date, dateIndex) in no_of_days" :key="dateIndex">
                  <div style="width: 14.29%" class="p-1 ">
                    <div @click="getDateValue(date)" x-text="date" class="cursor-pointer text-center text-sm  rounded-full leading-loose transition ease-in-out duration-100" :class="{'bg-purple-200 text-white': isToday(date) == true, 'text-gray-300 hover:text-white hover:bg-blue-100': isToday(date) == false }">
                      <div class="event bg-blue-100 text-white rounded p-1 text-sm mb-1">
                      <span class="event-name">
                        Meeting
                      </span>
                      <span class="time">
                        12:00~14:00
                      </span>
                    </div>
                    </div>
                  </div>
                </template>
              </div>
            </div>

          </div>
        </div>

      </div>

  
<script>
  const MONTH_NAMES = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
          const DAYS = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

  function calender() {
    return {
        datepickerValue: '',

        month: '',
        year: '',
        no_of_days: [],
        blankdays: [],
        days: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],

        initDate() {
            let today = new Date();
            this.month = today.getMonth();
            this.year = today.getFullYear();
            this.datepickerValue = new Date(this.year, this.month, today.getDate()).toDateString();
        },

        isToday(date) {
            const today = new Date();
            const d = new Date(this.year, this.month, date);

            return today.toDateString() === d.toDateString() ? true : false;
        },

        getDateValue(date) {
            console.log(date)
            let selectedDate = new Date(this.year, this.month, date);
            this.datepickerValue = selectedDate.toDateString();
            this.showDatepicker = false;
        },

        getNoOfDays() {
            let daysInMonth = new Date(this.year, this.month + 1, 0).getDate();

            // find where to start calendar day of week
            let dayOfWeek = new Date(this.year, this.month).getDay();
            let blankdaysArray = [];
            for ( var i=1; i <= dayOfWeek; i++) {
                blankdaysArray.push(i);
            }

            let daysArray = [];
            for ( var i=1; i <= daysInMonth; i++) {
                daysArray.push(i);
            }

            this.blankdays = blankdaysArray;
            this.no_of_days = daysArray;
        }
    }
}
</script>
