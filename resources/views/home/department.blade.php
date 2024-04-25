@extends('layout')
@section('content')
<style>
    .truncate {
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
    }
  
    .alert_custom {
      position: fixed;
      pointer-events: none;
      width: 100%;
      height: 100vh;
      top: 0;
      left: 0;
      z-index: 9999999999;
    }
  
    /* list */
    .alert_custom .list {
      display: flex;
      flex-direction: column;
      margin: 1rem;
      width: 100%;
      max-width: 400px;
      float: right;
    }
  
    /* item */
    .alert_custom .list .item {
      --line-height: 4px;
      position: relative;
      display: flex;
      align-items: center;
      padding: .5rem;
      color: #fff;
      border-radius: 0.25rem;
      overflow: hidden;
      padding-bottom: calc(.5rem + var(--line-height))
    }
    .alert_custom .list .item.success {
      background: #16A34A;
    }
    .alert_custom .list .item.error {
      background: #EAB308;
    }
  
    .alert_custom .list .item::after {
      content: "";
      position: absolute;
      width: 0;
      height: var(--line-height);
      background: #fff;
      bottom: 0;
      left: 0;
      animation: line 3s linear;
    }
  
    /* icon */
    .alert_custom .list .icon {
      flex: none;
      display: block;
      width: 40px;
      height: 40px;
    }
  
    .alert_custom .list .icon svg {
      width: 100%;
      height: 100%;
    }
  
    /* title */
    .alert_custom .list .title {
      min-width: 0;
      flex-grow: 1;
      margin-left: .5rem;
    }
  
    .alert_custom .list .title h6 {
      width: 100%;
      font-family: Arial, Helvetica, sans-serif !important;
      font-size: 14px !important;
      color: inherit !important;
      font-weight: bold;
      line-height: 1.5;
      margin: 0;
    }
  
    .alert_custom .list .title p {
      width: 100%;
      font-family: Arial, Helvetica, sans-serif !important;
      font-size: 12px !important;
      color: inherit !important;
      margin: 0rem !important;
      line-height: 1.5;
    }
  
    /* transiton */
    .transition_all {
      transition: all .3s ease-in-out;
    }
    .enter_start {
      transform: scale(0);
      opacity: 0;
    }
    .enter_end {
      transform: scale(1);
      opacity: 1;
    }
  
    .leave_start {
      transform: translateX(0);
      opacity: 1;
    }
    .leave_end {
      transform: translateX(100%);
      opacity: 0;
    }
  
    @keyframes line {
      from {
        width: 0;
      }
      to {
        width: 100%;
      }
    }
</style>
  {{-- @dd($tree) --}}
  
    @if ($message)
    <div class="w-full h-screen flex items-center justify-center">
        <div class="px-8 py-6 rounded-xl bg-gray-100 shadow-xl">
            <p class="text-2xl font-medium uppercase text-blue-800">{{$message}}</p>
        </div>
    </div>
    @else
    <main x-data="evaluations" >
        <div class="alert_custom">
            <div class="list">
              <template x-for="item in list" :key="item.id">
                <div class="item" x-show="item.show" 
                  x-transition:enter="transition_all"
                  x-transition:enter-start="enter_start"
                  x-transition:enter-end="enter_end"
                  x-transition:leave="transition_all"
                  x-transition:leave-start="leave_start"
                  x-transition:leave-end="leave_end"
                  :class="item.type">
                  <span class="icon">
                    <template x-if="item.type == 'success'">
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" style="fill: currentColor">
                        <path d="m10 15.586-3.293-3.293-1.414 1.414L10 18.414l9.707-9.707-1.414-1.414z"></path>
                      </svg>
                    </template>
                    <template x-if="item.type == 'error'">
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" style="fill: currentColor"><path d="M11.953 2C6.465 2 2 6.486 2 12s4.486 10 10 10 10-4.486 10-10S17.493 2 11.953 2zM12 20c-4.411 0-8-3.589-8-8s3.567-8 7.953-8C16.391 4 20 7.589 20 12s-3.589 8-8 8z"></path><path d="M11 7h2v7h-2zm0 8h2v2h-2z"></path></svg>
                    </template>
                  </span>
                  <div class="title">
                    <h6 class="truncate" x-text="item.title"></h6>
                    <p x-text="item.body"></p>
                  </div>
                </div>
              </template>
            </div>
          </div>
        <section class="flex items-center justify-center bg-emerald-50">
            <div class="w-full md:w-4/5 shadow-2xl p-4 my-8 bg-white rounded-md">
                <div class="relative pt-10 pb-5 px-2.5  border-t-2 border-blue-800">
                    <p class="text-3xl md:text-5xl text-center text-blue-900 uppercase">
                        ĐÁNH GIÁ TIÊU CHÍ CHẤM ĐIỂM THI ĐUA CỦA 
                        <br>
                        CÁC KHỐI - PHÒNG - BAN
                        <br>
                        NĂM HỌC {{$competition->years}}
                    </p>
                    <p class="text-center italic mt-4 text-blue-400">
                        (Kèm theo Hướng dẫn số 09/HD-HĐTĐKT, 
                            ngày 21/10/2020 của Hội đồng TĐKT thành phố Thái Nguyên)
                    </p>
                </div>
                <div class="relative pt-10 pb-5 px-2.5 mt-6 border-t-2 border-blue-800">
                    <h2 class="font-xl font-bold text-blue-800 py-1 px-3.5 absolute -top-5 left-5 bg-white border-2 border-blue-800 rounded-xl"> Thông tin người đánh giá</h2>
                    <div class="md:grid grid-rows-5 md:grid-rows-3 grid-flow-col gap-4">
                        <div class="md:row-span-3">
                            <img width="100px" src="{{ $department->logo ? Voyager::image($department->logo) : 'http://localhost/storage/users/default.png'}}" alt="">
                        </div>
                        <div class="md:col-span-2 ">
                            <div class="flex space-x-2 items-center">
                                <label for="name" class="font-bold text-black">Tên đơn vị:</label>
                                <p class="text-blue-600 font-medium">{{$department->name}}</p>
                            </div>
                            
                        </div>
                        <div class="md:row-span-2 md:col-span-2 ">
                            <div class="flex space-x-2 items-center">
                                <label for="name" class="font-bold text-black">Địa chỉ Email:</label>
                                <p class="text-blue-600 font-medium">{{$department->email}}</p>
                            </div>
                        </div>
                        <div class="md:col-span-3 ">
                            <div class="flex space-x-2 items-center">
                                <label for="name" class="font-bold text-black">Số điện thoại:</label>
                                <p class="text-blue-600 font-medium">{{$department->phone}}</p>
                            </div>
                        </div>
                        <div class="md:ow-span-2 md:col-span-3 ">
                            <div class="flex space-x-2 items-center">
                                <label for="name" class="font-bold text-black">Địa chỉ:</label>
                                <p class="text-blue-600 font-medium">{{$department->address}}</p>
                            </div>
                        </div>
                      </div>
                </div>
                <form action="{{route('send.evaluation')}}" method="post" enctype="multipart/form-data">  
                    @csrf
                    <div class="relative pt-10 pb-5 px-2.5 mt-6 border-t-2 border-blue-800"> 
                        <h2 class="font-xl font-bold text-blue-800 py-1 px-3.5 absolute -top-5 left-5 bg-white border-2 border-blue-800 rounded-xl">  Danh sách tiêu chí đánh giá</h2>
                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                            <table class="w-full overflow-scroll  text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                               
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        {{-- <th scope="col" class="px-6 py-3  border dark:bg-gray-800 dark:border-gray-700" >
                                            TT
                                        </th> --}}
                                        <th scope="col" class="px-6 py-3  border dark:bg-gray-800 dark:border-gray-700 ">
                                            TIÊU CHÍ
                                        </th>
                                        <th scope="col" class="px-6 py-3  border dark:bg-gray-800 dark:border-gray-700 ">
                                            PHƯƠNG PHÁP TÍNH ĐIỂM
                                        </th>
                                        <th scope="col" class="px-6 py-3 border dark:bg-gray-800 dark:border-gray-700 ">
                                            ĐIỂM ĐƠN VỊ CHẤM
                                        </th>
                                        <th scope="col" class="px-6 py-3  border dark:bg-gray-800 dark:border-gray-700 w-[10%]">
                                            FILE CHỨNG MINH 
                                        </th>
                                        <th scope="col" class="px-6 py-3 border dark:bg-gray-800 dark:border-gray-700 ">
                                            ĐIỂM KHOA - PHÒNG - BAN CHẤM
                                        </th>
                                    </tr>
                                </thead>

                                    <tbody x-html="renderCategories(data)">
                                    </tbody>
                                
                            </table>
                        </div>
                    </div>
                    <input type="hidden" name="type" value="department">
                    <div class="flex justify-end mt-6">
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 mb-4 rounded focus:outline-none focus:shadow-outline" 
                        type="submit"
                        ">
                            Gửi đánh giá
                        </button>
                    </div>
                </form>
                
            </div>
        </section>
    </main>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('evaluations', () => ({
                data: [],
                open: false,
                rows:[],
                index: 0,
                list: [],
                init() {
                    this.data = {!! $evaluations !!};
                    
                    let alert = JSON.parse(`@json(session()->get('alert'))`)
                    if (alert)
                        this.addAlert(alert)

                    
                },
                renderCategories(evaluations) {
                  console.log(evaluations)
                    let html = '';
                    Object.keys(evaluations).forEach(function(unitId) {
                      var evaluationss = evaluations[unitId];
                        html += `
                          <tr class="bg-green-800 ">
                            <th>
                              <p class=" py-2 px-4 text-white">${unitId}</p>
                            </th>
                          </tr>`
                      evaluationss.forEach(evaluation => {
                        
                        html += `
                            <tr class="bg-white ">
                                <th scope="row" class="px-6 py-4 font-normal  border dark:bg-gray-800 dark:border-gray-700">
                                    <span>${evaluation.criteria.name}</span>
                                </th>
                                <td class="px-6 py-4  border dark:bg-gray-800 dark:border-gray-700">
                                    ${evaluation.criteria.calculation}
                                </td>
                                <td class="px-6 py-4 border dark:bg-gray-800 dark:border-gray-700">
                                    <input type="number"  class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 " placeholder="Point" :value="${evaluation.uint_score}" readonly>
                                </td>
                                <td class="px-6 py-4  border dark:bg-gray-800 dark:border-gray-700 w-[10%]">
                                  ${
                                    evaluation.file == null ||  evaluation.file === "[]" ? `` : `<a target="_blank" href="{{Voyager::image('${evaluation.file}')}}" class="px-4 py-2 bg-blue-400 rounded-xl text-white max-w-max">Xem file</a>`
                                  }
                                  
                                </td>   
                                <td class="px-6 py-4 border dark:bg-gray-800 dark:border-gray-700">
                                    <input type="number" name="point[${evaluation.id}]" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Điểm"value="${evaluation.block_score ?? ''}" ></td>
                                
                            </tr>
                        `;
                      });
                    });
                   
                    return html;
                },
                
                addAlert(alert) {
                    this.list = [...JSON.parse(JSON.stringify(this.list)), {
                    id: ++this.index,
                    type: alert.type,
                    title: alert.title,
                    body: alert.body,
                    show: false
                    }]

                    this.$nextTick(() => {
                    this.list[this.index - 1].show = true
                    })

                    setTimeout(() => {
                    this.list[this.index - 1].show = false
                    }, 3000);
                }
            }))
        })
    </script>
    @endif
    
@endsection
