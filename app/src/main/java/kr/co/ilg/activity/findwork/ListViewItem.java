package kr.co.ilg.activity.findwork;

public class ListViewItem {
    public String title,date,pay,job,place,office,current_people,total_people;
    public boolean urgency;

    public ListViewItem(String title,String date,String pay,String job,String place,String office,String current_people,String total_people){
        this.title=title;
        this.date=date;
        this.pay=pay;
        this.job=job;
        this.place=place;
        this.office=office;
        this.current_people=current_people;
        this.total_people=total_people;
    }
    public ListViewItem(String title,String date,String pay,String job,String place,String office,String current_people,String total_people, boolean urgency){
        this.title=title;
        this.date=date;
        this.pay=pay;
        this.job=job;
        this.place=place;
        this.office=office;
        this.current_people=current_people;
        this.total_people=total_people;
        this.urgency =urgency;
    }
    public ListViewItem(String title, String place, String date)
    {
        this.title = title;
        this.place = place;
        this.date = date;


    }
}
