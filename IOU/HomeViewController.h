//
//  HomeViewController.h
//  IOU
//
//  Created by Bandi Enkh-Amgalan on 3/1/15.
//  Copyright (c) 2015 a. All rights reserved.
//

#import <UIKit/UIKit.h>

@interface HomeViewController : UIViewController <UITableViewDataSource, UITableViewDelegate>
{
    UITableView *tableView;
    NSManagedObjectContext *managedObjectContext;
    IBOutlet UILabel *oweAmount;
    IBOutlet UILabel *lentLabel;
    IBOutlet UILabel *oweLabel;
    IBOutlet UILabel *lentAmount;
    IBOutlet UITabBarItem *newButton;
}

@property UITableView* tableView;

@end
