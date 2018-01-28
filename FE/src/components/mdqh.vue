<template>
  <div>
    <el-container>
      <el-header>{{$route.params.empName}}</el-header>
      <el-main>
        <el-select v-model="shopID" filterable placeholder="请选择门店">
            <el-option
              v-for="item in sonCompanyResponse"
              :key="item.FItemID"
              :label="item.FName"
              :value="item.FItemID">
            </el-option>
        </el-select>
      </el-main>
      <el-footer> <el-button type="primary" @click="onSubmit">立即切换</el-button></el-footer>
    </el-container>
  </div>
</template>
<script>
  export default {
    data() {
      return {
        shopID:'',
        sonCompanyResponse:[],
      }
    },
    mounted(){
      this.$post('/Index/sonCompany',{toKey:localStorage.getItem('toKey')})
      .then(sonCompanyData=>{
        this.sonCompanyResponse = sonCompanyData;
      }).catch(error=>{
        this.$message(error);
        this.$router.push('/login')
      })

    },
    methods: {
      onSubmit() {
        this.$post('/Index/qhmd',{
          emp:this.$route.params.empID,
          sonCompany:this.shopID,
          toKey:localStorage.getItem('toKey')
        })
        .then(success=>{
          if(success == 'error'){
            this.$message('切换失败！');
          }else{
            this.$message('切换成功！');
            this.$router.go(-1);
          }
        }).catch(error=>{
          this.$message('切换失败！');
          this.$router.push('/login')
        })
      }
    }
  }
</script>

<style>
    .el-header{
      background-color: #E9EEF3;
      color: #333;
      text-align: center;
      line-height: 60px;
    }
    .el-main {
      color: #333;
      text-align: center;
    }
    .el-footer{
      text-align:center;
    }
</style>

