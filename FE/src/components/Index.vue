<template>
  <div>
    <el-container>
      <el-header><el-input v-model="search" placeholder="请输入收银员或门店"></el-input></el-header>
      <el-main>
      <el-table
        :data="resData"
        style="width: 100%"
        align="center"
        :default-sort = "{prop: 'empName', order: 'descending'}"
        @row-click="shopChange">
        <el-table-column
          prop="empName"
          sortable
          label="收银员">
        </el-table-column>
        <el-table-column
          prop="shopName"
          sortable
          label="门店">
        </el-table-column>
      </el-table>
      </el-main>
      <el-footer> <el-button type="text" @click="quit">安全退出</el-button></el-footer>
    </el-container>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        search:'',
        tableData: []
      }
    },
    computed:{
      resData:function(){
        var search = this.search;
        if(search){
          return this.tableData.filter(
            function(tableData){
              return Object.keys(tableData).some(
                function(key){
                  return String(tableData[key]).toLowerCase().indexOf(search) > -1
                }
              )
            }
          )
        }
        return this.tableData;
      }
    },
    mounted(){
      this.$post('/Index/cashier',{toKey:localStorage.getItem('toKey')})
      .then(response=>{
        if(response == 'error'){
          this.$router.push('/login')
        }else{
          this.tableData=response;
        }
      }).catch(error=>{
        this.$message(error);
        this.$router.push('/login')
      })
    },
    methods:{
      shopChange(row){
        this.$router.push('/mdqh/'+row.empID+'/'+row.empName);
      },
      quit(){
        localStorage.clear();
        this.$router.push('/login')
      }

    }
  }
</script>

<style>
    .el-header,.el-footer{
      background-color: #E9EEF3;
      color: #333;
      text-align: center;
      line-height: 60px;
    }
    .el-main {
      color: #333;
      text-align: center;
    }
</style>
