export enum EAdminRoute {
  Dashboard = '/api/admin/dashboard',
  Users = '/api/admin/users',
  Products = '/api/admin/products',
  Logs = '/api/admin/logs'
}

export enum EUserRole {
  Admin = 2,
  User = 1
}

export interface UserObject {
  readonly userid: number
  readonly apikey: string
  readonly role: number
}

export interface ILogins {
  readonly username: string
  readonly created_at: string
}
export interface IAdminDashboardData {
  readonly logins: ILogins[] 
  readonly productsCount: number
  readonly usersCount: number
}